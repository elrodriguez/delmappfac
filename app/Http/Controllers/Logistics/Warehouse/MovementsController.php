<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemWarehouse;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    public function list(){
        return datatables($this->itemWarehousesJoin())
           ->make(true);

    }

    public function itemWarehousesJoin(){

        return ItemWarehouse::query()->join('items','item_warehouses.item_id','items.id')
            ->join('warehouses','item_warehouses.warehouse_id','warehouses.id')
            ->select(
                'items.id AS item_id',
                'warehouses.id AS warehouse_id',
                'item_warehouses.id',
                'items.description AS item_description',
                'warehouses.description AS warehouse_description',
                'item_warehouses.stock'
            )
            ->orderBy('items.description');
    }

    public function searchProducts(Request $request){
        $products = Item::where('description','like','%'.$request->input('q').'%')
            ->where('item_type_id','01')
            ->select(
                'id AS value',
                'description AS text'
            )
            ->limit(200)
            ->get();

        return response()->json($products, 200);

    }
}
