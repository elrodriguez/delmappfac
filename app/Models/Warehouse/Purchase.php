<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'external_id',
        'establishment_id',
        'soap_type_id',
        'state_type_id',
        'group_id',
        'document_type_id',
        'series',
        'number',
        'date_of_issue',
        'time_of_issue',
        'supplier_id',
        'supplier',
        'currency_type_id',
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
        'legends'
    ];
}
