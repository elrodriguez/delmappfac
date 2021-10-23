<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductServicesController extends Controller
{
    public function list(){
        return datatables($this->queryJoin())
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->addColumn('edit_url', function($row){
                return route('academic_products_and_services_edit', $row->id);
            })
            ->make(true);
    }
    public function queryJoin(){
        return Item::query()->join('item_types','items.item_type_id','item_types.id')
        ->select([
            'items.id',
            'item_types.description AS item_type_description',
            'items.description',
            'items.sale_unit_price',
            DB::raw('IF(items.item_type_id="01",items.stock,"infinite") AS stock')
        ])
        ->where('module_type','ACD');
    }
}
