<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_id',
        'item_id',
        'brand_id',
        'warehouse_id',
        'quantity',
        'date_of_issue',
        'quantity_boxes',
        'pallets',
        'filas',
        'canastillas',
        'cajas',
        'unidades',
        'cubetas'
    ];
}
