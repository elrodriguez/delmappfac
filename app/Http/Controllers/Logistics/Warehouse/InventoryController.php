<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\ItemWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function inventoryItemWarehouse(Request $request){
        return datatables()->eloquent($this->itemsWarehouseQuery($request))
                ->addColumn('image_url',function($row){
                    $file = 'storage/items/'.$row->id.'.jpg';
                    if(file_exists(public_path($file))){
                        return asset('storage/items/'.$row->id.'.jpg');
                    }else{
                        return ui_avatars_url($row->description,50,'none',0);
                    }
                })
                ->toJson();
    }
    private function itemsWarehouseQuery($request){

        $warehouse_id = $request->input('warehouse_id');

        return ItemWarehouse::query()->join('items','item_warehouses.item_id','items.id')
            ->join('warehouses','item_warehouses.warehouse_id','warehouses.id')
            ->join('establishments','warehouses.establishment_id','establishments.id')
            ->leftJoin('brands','items.brand_id','brands.id')
            ->select(
                'items.id',
                'items.internal_id',
                'items.description',
                'brands.name',
                'establishments.name AS establishment_name',
                'warehouses.description AS warehouse_description',
                'item_warehouses.stock AS item_warehouse_stock',
                'items.sale_unit_price',
                'items.purchase_unit_price',
                DB::raw('(SELECT SUM(inventory_kardex.quantity) FROM inventory_kardex WHERE inventory_kardex.item_id = items.id) AS stock')
            )
            ->when($warehouse_id, function ($query) use ($warehouse_id) {
                return $query->where('item_warehouses.warehouse_id', $warehouse_id);
            })
            ->orderBy('items.description');
    }
}
