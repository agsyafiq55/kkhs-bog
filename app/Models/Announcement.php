<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
        'publish_start',
        'publish_end',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'publish_start' => 'datetime',
        'publish_end' => 'datetime',
    ];
    
    public function isActive()
    {
        $now = now();
        
        // If no publish range is set, check only published_at
        if (!$this->publish_start && !$this->publish_end) {
            return $this->published_at && $this->published_at->lte($now);
        }
        
        // Check if current time is within publish range
        $afterStart = !$this->publish_start || $this->publish_start->lte($now);
        $beforeEnd = !$this->publish_end || $this->publish_end->gte($now);
        
        return $this->published_at && $this->published_at->lte($now) && $afterStart && $beforeEnd;
    }
}