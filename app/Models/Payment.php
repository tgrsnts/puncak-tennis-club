<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'payment_method',
        'gross_amount',
        'status',
        'payment_code',
        'order_id',
        'payment_url',
        'paid_at',
        'expired_at',
        'settlement_time',
        'response_payload',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'settlement_time' => 'datetime',
        'response_payload' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
