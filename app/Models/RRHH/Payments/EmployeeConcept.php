<?php

namespace App\Models\RRHH\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeConcept extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'person_id',
        'concept_id',
        'amount',
        'state',
        'payment_date',
        'user_id',
        'observations'
    ];
}
