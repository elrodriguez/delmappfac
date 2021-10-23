<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'establishment_id',
        'establishment',
        'soap_type_id',
        'state_type_id',
        'prefix',
        'series',
        'number',
        'date_of_issue',
        'time_of_issue',
        'customer_id',
        'customer',
        'currency_type_id',
        'payment_method_type_id',
        'exchange_rate_sale',
        'apply_concurrency',
        'enabled_concurrency',
        'automatic_date_of_issue',
        'quantity_period',
        'type_period',
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
        'filename',
        'order_note_id',
        'total_canceled',
        'changed',
        'paid',
        'license_plate',
        'plate_number',
        'reference_data',
        'observation',
        'purchase_order',
        'document_id'
    ];
}
