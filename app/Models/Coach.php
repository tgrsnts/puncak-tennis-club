<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $table = 'coach';

    protected $fillable = [
        'name',
        'specialty',
        'photo_url',
    ];
}
