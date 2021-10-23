<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'description',
        'types'
    ];
}
