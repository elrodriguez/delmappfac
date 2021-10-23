<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_id',
        'payment_method_type_id',
        'description',
        'payment'
    ];

    public function payment_method_type()
    {
        return $this->belongsTo(\App\Models\Catalogue\CatPaymentMethodTypes::class,'payment_method_type_id');
    }
}
