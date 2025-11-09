<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'coach_id',
        'date',
        'start_time',
        'end_time',
        'level',
        'price',
        'max_slots',
    ];
    
    protected $appends = ['current_slots'];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getCurrentSlotsAttribute()
    {
        return $this->bookings()->count();
    }
}
