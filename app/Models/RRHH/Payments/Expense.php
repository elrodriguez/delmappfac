<?php

namespace App\Models\RRHH\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_type_id',
        'establishment_id',
        'person_id',
        'currency_type_id',
        'external_id',
        'number',
        'date_of_issue',
        'time_of_issue',
        'supplier',
        'exchange_rate_sale',
        'total',
        'state',
        'expense_reason_id',
        'employee_pay'
    ];
}
