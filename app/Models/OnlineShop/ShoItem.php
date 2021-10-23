<?php

namespace App\Models\OnlineShop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'title',
        'description',
        'color',
        'price',
        'stock',
        'state',
        'new_product',
        'seo_url'
    ];
}
