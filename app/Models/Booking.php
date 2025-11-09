<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'timetable_id',
        'status',
        'payment_status',
        'payment_id',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
