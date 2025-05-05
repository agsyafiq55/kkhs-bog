<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'aboutus';
    
    protected $fillable = [
        'organization_photo',
        'chairman_photo',
        'chairman_speech',
        'year',
    ];

    protected $attributes = [
        'chairman_speech' => '',
    ];

    public function setChairmanSpeechAttribute($value)
    {
        $this->attributes['chairman_speech'] = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
    }
}