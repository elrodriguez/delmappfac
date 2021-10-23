<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixed_phone',
        'mobile_phone',
        'logo',
        'email',
        'location_longitude',
        'location_latitude',
        'address',
        'discount',
        'email_default'
    ];
}
