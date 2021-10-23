<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_brand','id_item',
        'pallet_multiplo',
        'fila_multiplo',
        'canastilla_multiplo',
        'caja_multiplo',
        'unidad_multiplo',
        'cubeta_multiplo',
        'value_dividend'
    ];
}
