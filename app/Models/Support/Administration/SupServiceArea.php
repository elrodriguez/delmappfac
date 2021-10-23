<?php

namespace App\Models\Support\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupServiceArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'state'
    ];
}
