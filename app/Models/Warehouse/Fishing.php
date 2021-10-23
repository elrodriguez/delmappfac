<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fishing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'stock'
    ];
}
