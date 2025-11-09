<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Mark payment as settled (paid)
    public function settle(Request $request, Payment $payment)
    {
        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->settlement_time = now();
        $payment->save();

        if ($payment->booking) {
            $payment->booking->status = 'confirmed';
            $payment->booking->save();
        }

        return response()->json(['ok' => true, 'payment' => $payment]);
    }

    // Mark payment as expired
    public function expire(Request $request, Payment $payment)
    {
        $payment->status = 'expired';
        $payment->expired_at = now();
        $payment->save();

        if ($payment->booking) {
            $payment->booking->status = 'cancelled';
            $payment->booking->save();
        }

        return response()->json(['ok' => true, 'payment' => $payment]);
    }
}
