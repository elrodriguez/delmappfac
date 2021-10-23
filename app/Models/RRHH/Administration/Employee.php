<?php

namespace App\Models\RRHH\Administration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'family_burden',
        'curriculum',
        'bank_id',
        'account_number',
        'criminal_record',
        'drivers_license',
        'state'
    ];
}
