<?php

namespace App\Http\Controllers\Warehouse;

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

class PurchaseController extends Controller
{
    public function list(){
        return datatables(Purchase::query())
            ->addColumn('edit_url', function($row){
                return route('income_edit', $row->id);
            })->addColumn('delete_url', function($row){
                return route('income_delete', $row->id);
            })
            ->addColumn('purchase_number', function($row){
                return $row->series.'-'.$row->number;
            })
            ->editColumn('date_of_issue', function($row){
                return Carbon::parse($row->date_of_issue)->format('d/m/Y');
            })
            ->editColumn('supplier', function($row){
                $supplier = json_decode($row->supplier);
                return $supplier->trade_name;
            })
            ->order(function ($query) {
                $query->orderBy('id', 'DESC');
            })
            ->make(true);
    }
    public function destroy($id){
        $purchase = Purchase::find($id);
        if($purchase){
            $array = PurchaseItem::where('purchase_id',$id)->get();
            foreach($array as $item){
                Item::where('id',$item->id)->decrement('stock', $item->quantity);
            }
            PurchaseItem::where('purchase_id',$id)->delete();
            Kardex::where('purchase_id',$id)->delete();
            InventoryKardex::where('inventory_kardexable_id',$id)
                ->where('inventory_kardexable_type','=',Purchase::class)
                ->delete();

            $purchase->delete();

        }
        return response()->json(['success'=>true,'name'=>$purchase->number], 200);
    }

    // public function searchSupplier(){
    //     return datatables()->eloquent($this->queryJoin())->filter(function ($query) {
    //                         if (request()->has('supplier')) {
    //                             $query->where('name', 'like', "%" . request('supplier') . "%")
    //                             ->where('type','suppliers');
    //                         }
    //                     })
    //                     ->toJson();
    // }
    public function searchSupplier() {
        return Person::select([
                    'countries.description As country_name',
                    'departments.description AS department_name',
                    'provinces.description AS province_name',
                    'districts.description AS district_name',
                    'people.*'
                ])
                ->join('countries', 'people.country_id', '=', 'countries.id')
                ->join('departments', 'people.department_id', '=', 'departments.id')
                ->join('provinces', 'people.province_id', '=', 'provinces.id')
                ->join('districts', 'people.district_id', '=', 'districts.id')
                ->where(DB::raw("REPLACE(people.trade_name, ' ', '')"), 'LIKE', '%' . str_replace(' ','',request('supplier')). '%')
                ->orWhere(DB::raw("REPLACE(people.name, ' ', '')"), 'LIKE', '%' . str_replace(' ','',request('supplier')). '%')
                ->paginate(50);
    }

}
