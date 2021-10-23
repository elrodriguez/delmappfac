<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sack extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'customer_id',
        'fishing_id',
        'stock'
    ];
}
