<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function scopeOpenForBooking(Builder $query): Builder
    {
        $cutoff = Carbon::now('Asia/Jakarta')->addHour()->format('Y-m-d H:i:s');
        return $query->whereRaw("TIMESTAMP(`date`, `start_time`) > ?", [$cutoff]);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
