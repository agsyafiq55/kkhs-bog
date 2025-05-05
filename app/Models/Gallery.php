<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    // Specify the table name explicitly
    protected $table = 'gallery';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'img_name',
        'image',
        'description',
        'category'
    ];
}
