<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        abort(404);
    }

    /**
     * Halaman konfirmasi booking sebelum pembayaran.
     * expects query ?id=<timetable_id>
     */
    public function create(Request $request)
    {
        $id = $request->query('id');
        $timetable = Timetable::with('coach')->findOrFail($id);

        return view('user.booking.create', [
            'timetableId' => $id,
            'timetable'   => $timetable,
        ]);
    }

    /**
     * Simpan booking & buat transaksi Snap Midtrans.
     * Route: POST /{locale}/booking/{timetable}
     */
    public function store(Request $request, $locale = null)
    {
        $request->validate([
            'name'         => 'required|string|max:191',
            'phone'        => 'required|string|max:50',
            'person_count' => 'required|integer|min:1',
            'note'         => 'nullable|string|max:1000',
        ]);

        // Resolve timetable id from route or request (hidden input or query)
        $timetableId = $request->route('timetable') ?? $request->query('timetable') ?? $request->query('id') ?? $request->input('timetable_id');
        if (! $timetableId) {
            return response()->json(['error' => 'Timetable id missing'], 400);
        }

        $timetable = Timetable::with('coach')->find($timetableId);
        if (! $timetable) {
            return response()->json(['error' => 'Timetable not found'], 404);
        }

        $person_count = (int) $request->input('person_count', 1);
        $taken  = (int) ($timetable->current_slots ?? 0);
        $max    = (int) ($timetable->max_slots ?? 1);
        $remain = max(0, $max - $taken);

        if ($person_count > $remain) {
            return response()->json([
                'error'  => 'Not enough slots available',
                'remain' => $remain,
            ], 422);
        }

        $price = (int) ($timetable->price ?? 0);
        $total = $price * $person_count;

        $serverKey   = config('midtrans.server_key');
        $isProd      = (bool) config('midtrans.is_production', false);
        $midtransUrl = $isProd
            ? 'https://api.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        if (empty($serverKey)) {
            return response()->json([
                'error' => 'Midtrans server key is missing. Set MIDTRANS_SERVER_KEY in .env',
            ], 422);
        }

        DB::beginTransaction();

        try {
            // 1. Buat booking baru
            $booking = new Booking();
            $booking->timetable_id = $timetable->id;
            $booking->user_id      = Auth::id(); // null jika guest
            $booking->status       = 'pending';
            $booking->total_price  = $total;
            $booking->person_count = $person_count;
            $booking->notes        = $request->input('note');
            $booking->guest_name   = $request->input('name');
            $booking->guest_phone  = $request->input('phone');
            $booking->public_code  = (string) Str::uuid();
            $booking->save();

            // 2. Buat request ke Midtrans Snap (dengan timeout dan handling yang lebih toleran)
            // generate order id and pass it to payload so we can match notifications later
            $orderId = 'BOOK-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
            $payload = $this->buildMidtransPayload($booking, $timetable, $orderId);
            try {
                $response = Http::withBasicAuth($serverKey, '')->timeout(15)->post($midtransUrl, $payload);
            } catch (\Throwable $ex) {
                DB::rollBack();
                Log::error('Midtrans request exception', ['message' => $ex->getMessage()]);
                return response()->json(['error' => 'Payment gateway error', 'message' => $ex->getMessage()], 502);
            }

            $respBody = $response->body();
            $resp = null;
            try {
                $resp = $response->json();
            } catch (\Throwable $ex) {
                // ignore json decode errors, will check body
            }

            // prefer token from decoded JSON, fallback to attempting to parse body
            $token = is_array($resp) ? ($resp['token'] ?? null) : null;
            $redir = is_array($resp) ? ($resp['redirect_url'] ?? null) : null;
            if (! $token) {
                // try decode manually if json() failed
                $decoded = @json_decode($respBody, true);
                if (is_array($decoded)) {
                    $token = $decoded['token'] ?? $token;
                    $redir = $decoded['redirect_url'] ?? $redir;
                    $resp = $decoded;
                }
            }

            if (! $token) {
                DB::rollBack();
                Log::error('Midtrans returned no token', ['status' => $response->status(), 'body' => $respBody]);
                return response()->json(['error' => 'Failed to create Midtrans transaction', 'detail' => $respBody, 'status' => $response->status()], 502);
            }

            // 3. Simpan payment awal (pending)
            $payment = new Payment();
            $payment->booking_id       = $booking->id;
            $payment->payment_method   = 'midtrans_snap';
            $payment->gross_amount           = $total;
            $payment->status           = 'pending';
            $payment->payment_code     = $token;
            $payment->order_id         = $orderId;
            $payment->payment_url      = $redir;
            $payment->response_payload = json_encode($resp ?? []);

            // If Midtrans returned time fields, map them to our payment timestamps
            // common keys: transaction_time, settlement_time, expire_time, expiry_time
            $txTime = null;
            if (is_array($resp)) {
                $txTime = $resp['transaction_time'] ?? $resp['settlement_time'] ?? null;
                $expireTime = $resp['expire_time'] ?? $resp['expiry_time'] ?? null;
            } else {
                $expireTime = null;
            }

            if (!empty($txTime)) {
                // try parse as datetime
                try {
                    $payment->settlement_time = $txTime;
                    // if txTime implies paid, set paid_at
                    $payment->paid_at = $txTime;
                } catch (\Throwable $e) {
                    // ignore parse errors
                }
            }

            if (!empty($expireTime)) {
                try {
                    $payment->expired_at = $expireTime;
                } catch (\Throwable $e) {
                    // ignore
                }
            }

            $payment->save();

            DB::commit();

            // 4. Tentukan URL redirect sesuai user login / guest
            $urls = $this->buildFinishUrls($locale, $booking, $payment);

            return response()->json([
                'snap_token'      => $token,
                'redirect_url'    => $redir,
                'finish_redirect' => $urls['finish_redirect'],
                'public_url'      => $urls['public_url'],
                'success_url'     => $urls['success_url'],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'error'   => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Halaman detail booking (hanya user login).
     * Route: GET /{locale}/booking/{booking}
     */
    public function show($locale = null, Booking $booking)
    {
        $booking->load(['timetable.coach', 'payment']);
        return view('user.booking.show', compact('booking'));
    }

    /**
     * Halaman sukses transaksi (verifikasi payment_code).
     * Route: GET /{locale}/booking/success/{booking}/{code}
     */
    public function success($locale = null, Booking $booking, string $code)
    {
        $payment = $booking->payment;
        abort_if(!$payment || $payment->payment_code !== $code, 404);

        $booking->load(['timetable.coach', 'payment']);
        return view('user.booking.show', compact('booking', 'payment'));
    }

    /**
     * Link publik untuk guest (pakai public_code).
     * Route: GET /{locale}/booking/s/{code}
     */
    public function publicShow($locale = null, string $code)
    {
        $booking = Booking::with(['timetable.coach', 'payment'])
            ->where('public_code', $code)
            ->firstOrFail();

        return view('user.booking.show', compact('booking'));
    }

    /**
     * Regenerate Snap token (saat pending/challenge)
     * Route: POST /{locale}/booking/{booking}/snap
     */

    public function snap(Request $request, $locale = null, Booking $booking)
    {
        abort_if(! in_array($booking->status, ['pending', 'challenge']), 400);

        $serverKey = config('midtrans.server_key');
        $isProd    = (bool) config('midtrans.is_production', false);
        $snapUrl   = $isProd
            ? 'https://api.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // Pakai order_id lama kalau ada, else buat baru
        $existing = $booking->payment;
        $orderId  = $existing?->order_id ?: ('BOOK-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6)));

        $payload  = $this->buildMidtransPayload($booking, $booking->timetable, $orderId);

        $resp  = \Http::withBasicAuth($serverKey, '')->timeout(15)->post($snapUrl, $payload);
        if (!$resp->ok()) {
            return response()->json(['error' => 'Failed to create Midtrans transaction', 'detail' => $resp->body()], 502);
        }

        $data  = $resp->json();
        $token = $data['token'] ?? null;
        $redir = $data['redirect_url'] ?? null;
        if (!$token) {
            return response()->json(['error' => 'Midtrans did not return a token', 'detail' => $data], 502);
        }

        // SIMPAN order_id terbaru yang dipakai request Snap barusan!
        $payment = $booking->payment()->updateOrCreate(
            [], // hasOne by booking_id
            [
                'payment_method'   => 'midtrans_snap',
                'gross_amount'     => (int) $booking->total_price,
                'status'           => 'pending',
                'payment_code'     => $token,
                'payment_url'      => $redir,
                'order_id'         => $orderId,            // <— PENTING
                'response_payload' => json_encode($data),
            ]
        );

        $urls = $this->buildFinishUrls($locale, $booking, $payment);

        return response()->json([
            'snap_token'      => $token,
            'redirect_url'    => $redir,
            'finish_redirect' => $urls['finish_redirect'],
            'public_url'      => $urls['public_url'],
            'success_url'     => $urls['success_url'],
        ]);
    }


    /**
     * Builder payload Snap Midtrans
     */
    protected function buildMidtransPayload(Booking $booking, Timetable $timetable, ?string $orderId = null): array
    {
        $orderId = $orderId ?: 'BOOK-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));

        return [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->guest_name ?: optional($booking->user)->name,
                'phone'      => $booking->guest_phone ?: optional($booking->user)->phone,
            ],
            'item_details' => [[
                'id'       => 'TIMETABLE-' . $timetable->id,
                'price'    => (int) $timetable->price,
                'quantity' => (int) $booking->person_count,
                'name'     => 'Booking Session',
            ]],
        ];
    }

    /**
     * Redirect URL builder (bedakan guest & user login)
     */
    private function buildFinishUrls(?string $locale, Booking $booking, Payment $payment): array
    {
        $public  = route('booking.public', ['locale' => $locale, 'code' => $booking->public_code]);
        $success = route('booking.success', ['locale' => $locale, 'booking' => $booking->id, 'code' => $payment->payment_code]);

        if (auth()->check()) {
            return [
                'finish_redirect' => route('booking.show', ['locale' => $locale, 'booking' => $booking->id]),
                'public_url'      => $public,
                'success_url'     => $success,
            ];
        }

        // guest
        return [
            'finish_redirect' => $public, // tamu diarahkan ke link publik
            'public_url'      => $public,
            'success_url'     => $success,
        ];
    }
}
