<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'video_path',
        'type'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get video URL - now pointing to public/videos directory
     */
    public function getVideoUrlAttribute()
    {
        return $this->video_path ? asset($this->video_path) : null;
    }

    /**
     * Get video filename only
     */
    public function getVideoFilenameAttribute()
    {
        return $this->video_path ? basename($this->video_path) : null;
    }
}