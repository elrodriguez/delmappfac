<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectMaterial;
use App\Models\Master\Person;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectOrdersController extends Controller
{
    public function list(){
        return datatables(Project::query()->orderBy('created_at','DESC'))

            ->addColumn('materials_url', function($row){
                return route('logistics_production_projects_order_material', $row->id);
            })

            ->editColumn('date_start', function($row){
                return Carbon::parse($row->date_start)->format('d/m/Y');
            })
            ->editColumn('date_end', function($row){
                return Carbon::parse($row->date_end)->format('d/m/Y');
            })
            ->make(true);
    }
    public function responsable(){
        return datatables()->eloquent(Person::query())->filter(function ($query) {
                if (request()->has('responsable')) {
                    $query->where('name', 'like', "%" . request('responsable') . "%")
                    ->where('type','customers');
                }
            })
            ->toJson();
    }
    // public function searchItems(){
    //     return datatables()->eloquent($this->itemsQuery())
    //         ->filter(function ($query) {
    //             if (request()->has('search')) {
    //                 $query->where('items.internal_id', 'like', "%" . request('search') . "%")
    //                 ->orWhere('items.description', 'like', "%" . request('search') . "%");
    //             }
    //         })
    //         ->toJson();
    // }

    public function searchItems(){
        return  Item::leftJoin('brands','items.brand_id','brands.id')
        ->select(
            'items.id',
            'items.internal_id',
            'items.description',
            'items.purchase_unit_price',
            'items.stock',
            'brands.name'
        )->where(DB::raw("REPLACE(items.description, ' ', '')"), 'LIKE', '%' . str_replace(' ','',request('search')). '%')
        ->orWhere('items.internal_id', 'LIKE', '%' . request('search') . '%')
        ->paginate(50);
    }
    public function updateQuantityMaterial(Request $request){
        $quantity = $request->value;
        $id = $request->pk;
        $material = ProjectMaterial::where('id',$id);
        $price = $material->first()->unit_price;
        $material->update([
            'quantity'=>$quantity,
            'expenses' => ($quantity*$price)
        ]);
    }
    public function updatePriceMaterial(Request $request){
        $price = $request->value;
        $id = $request->pk;
        $material = ProjectMaterial::where('id',$id);
        $quantity = $material->first()->quantity;
        $material->update([
            'unit_price'=>$price,
            'expenses' => ($quantity*$price)
        ]);
    }
}
