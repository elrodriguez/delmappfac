<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFishing extends Model
{
    use HasFactory;

    protected $fillable =  [
        'code_id',
        'serie',
        'numero',
        'transfer_description',
        'observations',
        'departure_address',
        'arrival_address',
        'company_number',
        'company_description',
        'driver_number',
        'driver_plaque',
        'warehouse_id',
        'customer_id',
        'mode_of_travel',
        'reason_for_transfer',
        'measure_id',
        'departure_country_id',
        'departure_department_id',
        'departure_province_id',
        'departure_district_id',
        'arrival_country_id',
        'arrival_department_id',
        'arrival_province_id',
        'arrival_district_id',
        'company_document_type_id',
        'driver_document_type_id',
        'weight',
        'packages',
        'date_of_issue',
        'date_of_transfer',
        'pier_id',
        'user_id'
    ];
}
