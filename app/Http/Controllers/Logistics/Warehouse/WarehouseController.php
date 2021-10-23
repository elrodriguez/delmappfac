<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function list(){
        return datatables($this->warehouseJoin())
           ->addColumn('edit_url', function($row){
               return route('logistics_warehouse_inventory_locations_edit', $row->id);
           })
           ->addColumn('delete_url', function($row){
               return route('logistics_warehouse_inventory_locations_destroy', $row->id);
           })
           ->make(true);
   }
   private function warehouseJoin(){
        return Warehouse::query()->join('establishments','warehouses.establishment_id','establishments.id')
            ->select(
                'warehouses.id',
                'warehouses.description',
                'establishments.name'
            );
   }

   public function destroy($id){
    $warehouse = Warehouse::find($id);
    if($warehouse){
        $warehouse->delete();
    }
    return response()->json(['success'=>true,'name'=>$warehouse->name], 200);
}
}
