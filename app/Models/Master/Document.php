<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'establishment_id',
        'establishment',
        'soap_type_id',
        'state_type_id',
        'ubl_version',
        'group_id',
        'document_type_id',
        'series',
        'number',
        'date_of_issue',
        'time_of_issue',
        'customer_id',
        'customer',
        'currency_type_id',
        'purchase_order',
        'exchange_rate_sale',
        'total_prepayment',
        'total_charge',
        'total_discount',
        'total_exportation',
        'total_free',
        'total_taxed',
        'total_unaffected',
        'total_exonerated',
        'total_igv',
        'total_base_isc',
        'total_isc',
        'total_base_other_taxes',
        'total_other_taxes',
        'total_plastic_bag_taxes',
        'total_taxes',
        'total_value',
        'total',
        'charges',
        'discounts',
        'prepayments',
        'guides',
        'related',
        'perception',
        'detraction',
        'legends',
        'additional_information',
        'filename',
        'hash',
        'qr',
        'has_xml',
        'has_pdf',
        'has_cdr',
        'send_server',
        'shipping_status',
        'sunat_shipping_status',
        'query_status',
        'data_json',
        'used',
        'module'
    ];

    protected $casts = [
        'date_of_issue' => 'date',
    ];

    public function invoice()
    {
        return $this->hasMany(Invoices::class);
    }
    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }
    public function payments()
    {
        return $this->hasMany(\App\Models\Master\DocumentPayment::class,'document_id');
    }

    public function document_type()
    {
        return $this->belongsTo(\App\Models\Catalogue\DocumentType::class, 'document_type_id');
    }

    public function note()
    {
        return $this->hasOne(\App\Models\Master\Note::class,'document_id');
    }
    
}
