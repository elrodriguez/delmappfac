<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SackProduced extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_fishing_id',
        'fishing_id',
        'freezer_id',
        'customer_id',
        'customer',
        'quantity',
        'sack_id',
        'user_id'
    ];
}
