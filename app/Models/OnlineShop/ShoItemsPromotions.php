<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoItemsPromotions extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'item_id',
        'price'
    ];
}
