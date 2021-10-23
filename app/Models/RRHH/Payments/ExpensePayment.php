<?php

namespace App\Models\RRHH\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'date_of_payment',
        'expense_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'payment',
        'bank_account_id'
    ];
}
