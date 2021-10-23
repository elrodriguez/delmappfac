<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'active',
        'symbol',
        'description'
    ];
}
