<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'item_type_id',
        'internal_id',
        'item_code',
        'item_code_gs1',
        'unit_type_id',
        'currency_type_id',
        'sale_unit_price',
        'purchase_unit_price',
        'has_isc',
        'system_isc_type_id',
        'percentage_isc',
        'suggested_price',
        'sale_affectation_igv_type_id',
        'purchase_affectation_igv_type_id',
        'stock',
        'stock_min',
        'attributes',
        'module_type',
        'digemid',
        'apply_store',
        'status',
        'active',
        'percentage_perception',
        'has_perception',
        'percentage_of_profit',
        'series_enabled',
        'lots_enabled',
        'image',
        'image_medium',
        'image_small',
        'brand_id',
        'category_id',
        'is_set',
        'sale_unit_price_set',
        'calculate_quantity',
        'commission_type',
        'line',
        'account_id',
        'date_of_due',
        'name',
        'second_name',
        'has_igv',
        'has_plastic_bag_taxes',
        'barcode',
        'lot_code',
        'commission_amount'
    ];

}
