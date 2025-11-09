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

class BookingController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $id = $request->query('id');

        $timetable = Timetable::find($id);

        return view('user.booking.create', [
            'timetableId' => $id,
            'timetable' => $timetable
        ]);
    }

    public function store(Request $request, $locale = null, $id = null)
    {
        // 1) Validasi input
        $request->validate([
            'name'         => 'required|string|max:191',
            'phone'        => 'required|string|max:50',
            'participants' => 'required|integer|min:1',
            'note'         => 'nullable|string|max:1000',
        ]);

        // 2) Ambil timetable dari {id} route param
        $timetable = Timetable::find($id);
        if (!$timetable) {
            return response()->json(['error' => 'Timetable not found'], 404);
        }

        $participants = (int) $request->input('participants', 1);

        // 3) Hitung slot aman
        $taken  = (int) ($timetable->current_slots ?? 0);  // pastikan tidak null
        $max    = (int) ($timetable->max_slots ?? 1);
        $remain = max(0, $max - $taken);
        if ($participants > $remain) {
            return response()->json([
                'error'  => 'Not enough slots available',
                'remain' => $remain
            ], 422);
        }

        // 4) Hitung total
        $price = (int) ($timetable->price ?? 0);
        $total = $price * $participants;

        // 5) Cek Midtrans key terlebih dahulu (biar gak 500 misterius)
        $serverKey   = env('MIDTRANS_SERVER_KEY');
        $isProd      = (bool) env('MIDTRANS_PRODUCTION', false);
        $midtransUrl = $isProd
            ? 'https://api.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        if (empty($serverKey)) {
            // Balikin 422 yang jelas kalau key belum diisi
            return response()->json([
                'error'  => 'Midtrans server key is missing. Set MIDTRANS_SERVER_KEY in .env',
            ], 422);
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id();            // 6) JANGAN pakai 'guest' string
            // pastikan kolom user_id nullable di migration bookings
            // kalau guest → null, aman
            $booking = new Booking();
            $booking->timetable_id = $timetable->id;
            $booking->user_id      = $userId;            // null kalau guest
            $booking->status       = 'pending';
            $booking->total_price  = $total;
            $booking->person_count = $participants;
            $booking->notes        = $request->input('note');
            $booking->save();

            // 7) Buat order_id & payload Midtrans
            $orderId = 'BOOK-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));

            $payload = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => $request->input('name'),
                    'phone'      => $request->input('phone'),
                ],
                'item_details' => [[
                    'id'       => 'TIMETABLE-' . $timetable->id,
                    'price'    => $price,
                    'quantity' => $participants,
                    'name'     => 'Booking Session',
                ]],
            ];

            $response = Http::withBasicAuth($serverKey, '')
                ->post($midtransUrl, $payload);

            // 8) Tangani response Midtrans dengan aman
            $respBody = $response->body();
            $resp     = null;
            try {
                $resp = $response->json();
            } catch (\Throwable $e) { /* ignore */
            }

            $token = is_array($resp) ? ($resp['token'] ?? null) : null;
            $redir = is_array($resp) ? ($resp['redirect_url'] ?? null) : null;

            if (!$token && !$response->ok()) {
                DB::rollBack();
                return response()->json([
                    'error'  => 'Failed to create Midtrans transaction',
                    'detail' => $respBody,
                ], 502); // gunakan 502/400 daripada 500
            }

            // 9) Simpan payment
            $payment = new Payment();
            $payment->booking_id     = $booking->id;
            $payment->payment_method = 'midtrans_snap';
            $payment->amount         = $total;
            $payment->status         = 'pending';
            $payment->payment_code   = $token;
            $payment->payment_url    = $redir;
            $payment->paid_at        = null;
            $payment->expired_at     = null;
            $payment->settlement_time = null;            // pending → null
            $payment->response_payload = json_encode($resp ?? []);
            $payment->save();

            DB::commit();

            // 10) Sertakan locale saat build URL
            return response()->json([
                'snap_token'      => $token,
                'redirect_url'    => $redir, // kalau mau langsung pakai redirect_url
                'finish_redirect' => route('booking.show', ['locale' => $locale, 'id' => $booking->id]),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            // Log lengkap ke laravel.log
            report($e);

            return response()->json([
                'error'   => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        //
    }
}
