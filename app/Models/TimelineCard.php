<?php

// app/Models/TimelineCard.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'description',
        'description_zh',
        'position',
    ];
}