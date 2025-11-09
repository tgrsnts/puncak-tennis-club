<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransNotificationController extends Controller
{
    /**
     * Midtrans will POST JSON or x-www-form-urlencoded.
     * We verify signature_key, then map transaction_status -> our enums, then update Payment & Booking.
     * Always return 200 "OK" quickly.
     */
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('Midtrans notification received', $payload);

            $orderId           = $payload['order_id'] ?? $payload['orderId'] ?? null;
            $statusCode        = $payload['status_code'] ?? null;
            $grossAmount       = $payload['gross_amount'] ?? null;
            $transactionStatus = $payload['transaction_status'] ?? $payload['transactionStatus'] ?? null;
            $paymentType       = $payload['payment_type'] ?? null;
            $fraudStatus       = $payload['fraud_status'] ?? null;
            $signatureKey      = $payload['signature_key'] ?? null;
            $transactionTime   = $payload['transaction_time'] ?? null;
            $settlementTime    = $payload['settlement_time'] ?? null;
            $expiryTime        = $payload['expiry_time'] ?? ($payload['expire_time'] ?? null);

            if (!$orderId) {
                Log::warning('Midtrans notification missing order_id', $payload);
                return response('OK', 200);
            }

            // signature check
            $serverKey = config('midtrans.server_key');
            if (!empty($serverKey)) {
                $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
                if (!$signatureKey || !hash_equals($expected, $signatureKey)) {
                    Log::warning('Midtrans signature mismatch', [
                        'order_id' => $orderId,
                        'expected' => $expected,
                        'got' => $signatureKey,
                    ]);
                    return response('OK', 200);
                }
            } else {
                Log::warning('Midtrans server_key missing; skipping signature verification');
            }

            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                Log::warning('Payment not found for order_id', ['order_id' => $orderId]);
                return response('OK', 200);
            }

            $booking = $payment->booking;
            if (in_array($payment->status, ['paid', 'failed', 'expired'], true)) {
                Log::info('Payment already final; skip', ['order_id' => $orderId, 'status' => $payment->status]);
                return response('OK', 200);
            }

            $payment->response_payload = json_encode($payload);
            if ($paymentType) $payment->payment_type = $paymentType;
            if (!empty($payload['va_numbers'][0]['va_number'])) {
                $payment->va_number = $payload['va_numbers'][0]['va_number'];
            }
            if (!empty($payload['va_numbers'][0]['bank'])) {
                $payment->va_bank = strtoupper($payload['va_numbers'][0]['bank']);
            }

            $new = $payment->status ?: 'pending';
            switch ($transactionStatus) {
                case 'capture':
                    $new = ($fraudStatus === 'challenge') ? 'pending' : 'paid';
                    if ($new === 'paid') {
                        $payment->paid_at = now();
                        $payment->settlement_time = $settlementTime ?: now();
                        if ($booking) $booking->status = 'confirmed';
                    }
                    break;
                case 'settlement':
                    $new = 'paid';
                    $payment->paid_at = now();
                    $payment->settlement_time = $settlementTime ?: now();
                    if ($booking) $booking->status = 'confirmed';
                    break;
                case 'pending':
                    $new = 'pending';
                    if ($expiryTime && empty($payment->expired_at)) $payment->expired_at = $expiryTime;
                    if ($booking && $booking->status !== 'confirmed') $booking->status = 'pending';
                    break;
                case 'expire':
                    $new = 'expired';
                    $payment->expired_at = now();
                    if ($booking) $booking->status = 'cancelled';
                    break;
                default:
                    $new = 'failed';
                    if ($booking && $booking->status !== 'confirmed') $booking->status = 'cancelled';
            }

            $payment->status = $new;
            if ($transactionTime && empty($payment->paid_at) && $new === 'paid') {
                $payment->paid_at = $transactionTime;
            }

            $payment->save();
            if ($booking) $booking->save();

            return response('OK', 200);
        } catch (\Throwable $e) {
            Log::error('Midtrans notify exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response('OK', 200); // still OK to stop retries
        }
    }
}
