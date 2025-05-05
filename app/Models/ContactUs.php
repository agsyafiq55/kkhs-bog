<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';
    protected $fillable = [
        'address',
        'email',
        'phone_no1',
        'phone_no2',
        'map_url',
    ];
}
