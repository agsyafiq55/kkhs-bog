<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'article',
        'event_date',
        'thumbnail',
        'tag',
        'is_highlighted',
    ];

    protected $attributes = [
        'article' => '',
    ];

    public function setArticleAttribute($value)
    {
        $this->attributes['article'] = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
    }
}



