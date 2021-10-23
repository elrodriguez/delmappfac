<?php

namespace App\Models\RRHH\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'concept_id',
        'description',
        'total',
        'proj_emp_id'
    ];
}
