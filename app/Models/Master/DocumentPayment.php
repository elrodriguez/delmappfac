<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPayment extends Model
{
    use HasFactory;

    protected $with = ['payment_method_type', 'card_brand'];
    //public $timestamps = false;

    protected $fillable = [
        'document_id',
        'date_of_payment',
        'payment_method_type_id',
        'has_card',
        'card_brand_id',
        'reference',
        'change',
        'payment'
    ];

    protected $casts = [
        'date_of_payment' => 'date',
    ];

    public function payment_method_type()
    {
        return $this->belongsTo(\App\Models\Catalogue\CatPaymentMethodTypes::class,'payment_method_type_id','id');
    }

    public function card_brand()
    {
        return $this->belongsTo(CardBrand::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }


    public function global_payment()
    {
        return $this->morphOne(\App\Models\Master\GlobalPayment::class, 'payment');
    }

    public function associated_record_payment()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    // public function payment_file()
    // {
    //     return $this->morphOne(PaymentFile::class, 'payment');
    // }
}
