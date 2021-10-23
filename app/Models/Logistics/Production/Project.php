<?php

namespace App\Models\Logistics\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'person_id',
        'country_id',
        'department_id',
        'province_id',
        'district_id',
        'address',
        'date_start',
        'date_end',
        'budget',
        'investment',
        'type',
        'state',
        'establishment_id',
        'customer_id',
        'person_customer_id'
    ];
}
