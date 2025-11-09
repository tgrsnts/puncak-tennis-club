<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'timetable_id',
        'user_id',
        'status',
        'total_price',
        'person_count',
        'notes',
        'guest_name',
        'guest_phone',
        'public_code',
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
