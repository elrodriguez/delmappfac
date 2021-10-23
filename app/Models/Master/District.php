<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'province_id',
        'description',
        'active'
    ];

}
