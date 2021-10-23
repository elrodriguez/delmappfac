<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoriesTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'warehouse_id',
        'warehouse_destination_id',
        'quantity'
    ];

    public function warehouse()
    {
        return $this->belongsTo(\App\Models\Warehouse\Warehouse::class,'warehouse_id');
    }

    public function warehouse_destination()
    {
        return $this->belongsTo(\App\Models\Warehouse\Warehouse::class, 'warehouse_destination_id');
    }

    public function inventory()
    {
        return $this->hasMany(\App\Models\Warehouse\Inventory::class, 'inventories_transfer_id');
    }
}
