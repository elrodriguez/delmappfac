<?php

namespace App\Models\RRHH\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'percentage',
        'operation'
    ];

}
