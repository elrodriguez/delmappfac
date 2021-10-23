<?php

namespace App\Models\Support\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupServiceAreaUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'sup_service_area_id',
        'user_id',
        'sup_service_area_group_id'
    ];
}
