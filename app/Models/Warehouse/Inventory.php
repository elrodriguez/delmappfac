<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'item_id',
        'warehouse_id',
        'warehouse_destination_id',
        'quantity',
        'inventory_transaction_id',
        'lot_code',
        'inventories_transfer_id',
        'detail'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouse_destination()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_destination_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function inventory_kardex()
    {
        return $this->morphMany(InventoryKardex::class, 'inventory_kardexable');
    }

    public function transaction()
    {
        return $this->belongsTo(InventoryTransaction::class);
    }
}
