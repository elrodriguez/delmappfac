<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'url_action',
        'total_price',
        'state'
    ];
}
