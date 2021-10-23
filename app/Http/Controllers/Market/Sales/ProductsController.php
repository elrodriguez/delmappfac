<?php

namespace App\Http\Controllers\Market\Sales;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // public function searchItems(){
    //     //dd(request('search'));
    //     return datatables()->eloquent($this->itemsQuery())
    //         ->filter(function ($query) {
    //             if (request()->has('search')) {
    //                 $query->where('items.internal_id', '=', request('search') )
    //                 ->orWhere('items.description', 'like', "%" . request('search') . "%");
    //             }
    //         })
    //         ->addColumn('image_url', function($row){
    //             $image_path = public_path('storage/items/'.$row->id);
    //             if (file_exists($image_path)) {
    //                 return asset('storage/items/'.$row->id).'.jpg';
    //             }else{
    //                 return ui_avatars_url($row->name,50,'none');
    //             }
    //         })
    //         ->toJson();
    // }

    public function searchItems(Request $request){

        $warehouse_id = Warehouse::where('establishment_id',Auth::user()->establishment_id)->first()->id;
        $search = $request->input('search');
        $items = Item::leftJoin('brands','items.brand_id','brands.id')
            ->join('item_warehouses','item_warehouses.item_id','items.id')
            ->select(
                'items.id',
                'items.internal_id',
                'items.description',
                'brands.name',
                'items.has_plastic_bag_taxes',
                'items.sale_unit_price'
            )
            ->selectSub(function($query) {
                $query->from('inventory_kardex')->selectRaw('SUM(quantity)')
                ->whereColumn('inventory_kardex.item_id','items.id')
                ->whereColumn('inventory_kardex.warehouse_id','item_warehouses.warehouse_id');
            }, 'stock')
            ->where('item_warehouses.warehouse_id',$warehouse_id)
            ->whereNotIn('module_type',['GOO'])
            ->where(function($query) use ($search){
                $query->where('items.internal_id', '=', $search)
                    ->orWhere(DB::raw("REPLACE(items.description, ' ', '')"), 'like', "%" .str_replace(' ','',$search). "%");
            })
            ->orderBy('items.description')
            ->limit(100)
            ->get();

            $data = [];
                
        foreach ($items as $key => $item){
            $file = 'storage/items/'.$item->id.'.jpg';
            $image = '';
            if(file_exists(public_path($file))){
                $image = asset('storage/items/'.$item->id.'.jpg');
            }else{
                $image = ui_avatars_url($item->description,50,'none',0);
            }
            $data[$key] = [
                'id' => $item->id,
                'internal_id' => $item->internal_id,
                'description' => $item->description,
                'has_plastic_bag_taxes' => $item->has_plastic_bag_taxes,
                'name' => $item->name,
                'stock' => $item->stock,
                'image_url' => $image,
                'sale_price' => $item->sale_unit_price
            ];
        }

        return response()->json(['success'=>true,'data'=>$data], 200);
    }
}
