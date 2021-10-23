<?php

namespace App\Models\Catalogue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPaymentMethodTypes extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'description',
        'has_card',
        'charge',
        'number_days'
    ];

    public function document_payments()
    {
        return $this->hasMany(DocumentPayment::class, 'payment_method_type_id');
    }

    // public function sale_note_payments()
    // {
    //     return $this->hasMany(SaleNotePayment::class, 'payment_method_type_id');
    // }

    // public function purchase_payments()
    // {
    //     return $this->hasMany(PurchasePayment::class, 'payment_method_type_id');
    // }

    // public function quotation_payments()
    // {
    //     return $this->hasMany(QuotationPayment::class, 'payment_method_type_id');
    // }

    // public function contract_payments()
    // {
    //     return $this->hasMany(ContractPayment::class, 'payment_method_type_id');
    // }

    // public function income_payments()
    // {
    //     return $this->hasMany(IncomePayment::class, 'payment_method_type_id');
    // }

    public function cash_transactions()
    {
         return $this->hasMany(\App\Models\Master\CashTransaction::class, 'payment_method_type_id','id');
    }

    // public function technical_service_payments()
    // {
    //     return $this->hasMany(TechnicalServicePayment::class, 'payment_method_type_id');
    // }


    // public function scopeWhereFilterPayments($query, $params)
    // {

    //     return $query->with(['document_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser();
    //                     });
    //             },
    //             'sale_note_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser()
    //                             ->whereNotChanged();
    //                     });
    //             },
    //             'quotation_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser()
    //                             ->whereNotChanged();
    //                     });
    //             },
    //             'contract_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser()
    //                             ->whereNotChanged();
    //                     });
    //             },
    //             'purchase_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser();
    //                     });
    //             },
    //             'income_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereStateTypeAccepted()->whereTypeUser();
    //                     });
    //             },
    //             'cash_transactions' => function($q) use($params){
    //                 $q->whereBetween('date', [$params->date_start, $params->date_end]);
    //             },
    //             'technical_service_payments' => function($q) use($params){
    //                 $q->whereBetween('date_of_payment', [$params->date_start, $params->date_end])
    //                     ->whereHas('associated_record_payment', function($p){
    //                         $p->whereTypeUser();
    //                     });
    //             }
    //             ]);

    // }
}
