<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse\Purchase;
use Illuminate\Support\Carbon;
use App\Models\Master\Person;
use App\Models\Warehouse\PurchaseItem;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\Kardex;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function list(){
        return datatables($this->shoppingJoin())
            ->addColumn('edit_url', function($row){
                return route('logistics_warehouse_shopping_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('logistics_warehouse_shopping_delete', $row->id);
            })
            ->addColumn('products_url', function($row){
                return route('logistics_warehouse_shopping_details', $row->id);
            })
            ->editColumn('date_of_issue', function($row){
                return Carbon::parse($row->date_of_issue)->format('d/m/Y');
            })
            ->editColumn('supplier', function($row){
                $supplier = json_decode($row->supplier);
                return $supplier->trade_name;
            })
            ->addColumn('state', function($row){
                return $row->state;
            })
            ->addColumn('coin', function($row){
                return $row->currency_type_id;
            })
            ->addColumn('purchase_number', function($row){
                return $row->series.'-'.$row->number;
            })
            ->order(function ($query) {
                $query->orderBy('purchases.id', 'DESC');
            })
            ->make(true);
    }
    public function shoppingJoin(){
        return Purchase::query()->leftJoin('document_types','purchases.document_type_id','document_types.id')
        ->leftJoin('state_types','purchases.state_type_id','state_types.id')
        ->select([
            'purchases.id',
            'purchases.date_of_issue',
            'purchases.series',
            'purchases.number',
            'purchases.supplier',
            'purchases.currency_type_id',
            'purchases.total',
            'document_types.description',
            'state_types.description as state'
        ]);
    }

    public function queryJoin() {
        return Person::query()->select([
                    'countries.description As country_name',
                    'departments.description AS department_name',
                    'provinces.description AS province_name',
                    'districts.description AS district_name',
                    'people.*'
                ])
                ->join('countries', 'people.country_id', '=', 'countries.id')
                ->join('departments', 'people.department_id', '=', 'departments.id')
                ->join('provinces', 'people.province_id', '=', 'provinces.id')
                ->join('districts', 'people.district_id', '=', 'districts.id');
    }


    public function destroy($id){//anular
        $purchase = Purchase::find($id);
        if($purchase){
            $array = PurchaseItem::where('purchase_id',$id)->get();
            
            foreach($array as $item){
                
                Item::where('id',$item->id)->decrement('stock', $item->quantity);
                DB::table('inventory_kardex')->insert([
                    'date_of_issue' => Carbon::now()->format('Y-m-d'),
                    'item_id' => $item->id,
                    'inventory_kardexable_id' => $id,
                    'inventory_kardexable_type' => Purchase::class,
                    'warehouse_id' => 1,
                    'quantity'=>(-$item->quantity)
                ]);
                
                //update registrado a anulado
            }
           $purchase->update(['state_type_id' => 11 ]);

           /*PurchaseItem::where('purchase_id',$id)->delete();
            Kardex::where('purchase_id',$id)->delete();
            InventoryKardex::where('inventory_kardexable_id',$id)
                ->where('inventory_kardexable_type','=',Purchase::class)
                ->delete();
            $purchase->delete();*/

        }
        return response()->json(['success'=>true,'name'=>$purchase->number], 200);
    }

    public function searchSupplier(){
        return datatables()->eloquent($this->queryJoin())->filter(function ($query) {
                            if (request()->has('supplier')) {
                                $query->where('name', 'like', "%" . request('supplier') . "%")
                                ->where('type','suppliers');
                            }
                        })
                        ->toJson();
    }
    public function detailsProductsPurchase($id){
        $items =  PurchaseItem::where('purchase_id',$id)->get();
        $data = [];
        foreach($items as $key => $item){
            $data[$key] = [
                'item_id' => $item->item_id,
                'code' => json_decode($item->item)->internal_id,
                'description' => json_decode($item->item)->description,
                'quantity' => $item->quantity,
                'total' => $item->total
            ];
        }
        return $data;
    }


}
