<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialsKardexController extends Controller
{
    public function materialslist(Request $request){

        $item_id = $request->input('item_id');
        $warehouse_id = $request->input('warehouse_id');

        $materials = InventoryKardex::join('items','kardex.item_id','items.id')
            ->leftJoin('purchases', function($query)
            {
                $query->on('inventory_kardex.inventory_kardexable_id','purchases.id')
                    ->where('inventory_kardex.inventory_kardexable_type', Purchase::class);
            })
            ->join('warehouses','inventory_kardex.warehouse_id','warehouses.id')
            ->select(
                'inventory_kardex.date_of_issue',
                'inventory_kardex.quantity',
                'items.description AS item_description',
                'warehouses.description AS warehouse_description',
                DB::raw('CONCAT(purchases.series,"-",purchases.number) AS purchase_number'),
                DB::raw('IF(inventory_kardex.inventory_kardexable_type=="'.Inventory::class.'","Stock Inicial",NULL)')
            )
            ->where('warehouses.id',$warehouse_id)
            ->when($item_id, function ($query,$item_id) {
                return $query->where('items.id', $item_id);
            })
            ->get();

        return $materials;
    }
}
