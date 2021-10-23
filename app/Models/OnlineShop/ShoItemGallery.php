<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoItemGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_item_id',
        'item_id',
        'url',
        'name',
        'state',
        'principal'
    ];
}
