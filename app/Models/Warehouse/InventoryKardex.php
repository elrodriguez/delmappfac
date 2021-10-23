<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class InventoryKardex extends Model
{

    protected $table = 'inventory_kardex';

    protected $fillable =  [
        'date_of_issue',
        'item_id',
        'inventory_kardexable_id',
        'inventory_kardexable_type',
        'warehouse_id',
        'quantity'
    ];

}
