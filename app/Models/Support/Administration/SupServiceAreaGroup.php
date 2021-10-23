<?php

namespace App\Models\Support\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupServiceAreaGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_service_area_id',
        'description',
        'state'
    ];
}
