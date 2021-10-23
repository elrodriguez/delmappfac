<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'soap_type_id',
        'destination_id',
        'destination_type',
        'payment_id',
        'payment_type',
        'user_id'
    ];

    public function destination()
    {
        return $this->morphTo();
    }


    public function payment()
    {
        return $this->morphTo();
    }

    public function doc_payments()
    {
        return $this->belongsTo(DocumentPayment::class, 'payment_id')
                    ->wherePaymentType(DocumentPayment::class);
    }
    public function exp_payment()
    {
        return $this->belongsTo(\App\Models\RRHH\Payments\ExpensePayment::class, 'payment_id')
                    ->wherePaymentType(ExpensePayment::class);
    }

    // public function sln_payments()
    // {
    //     return $this->belongsTo(SaleNotePayment::class, 'payment_id')
    //                 ->wherePaymentType(SaleNotePayment::class);
    // }

    // public function pur_payment()
    // {
    //     return $this->belongsTo(PurchasePayment::class, 'payment_id')
    //                 ->wherePaymentType(PurchasePayment::class);
    // }
}
