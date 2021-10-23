<?php

namespace App\Http\Controllers\Logistics\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    // public function searchItem(){
    //     return datatables()->eloquent($this->itemsQuery())
    //         ->filter(function ($query) {
    //             if (request()->has('search')) {
    //                 $query->where('items.internal_id',"=", request('search'))
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
    public function searchItem(Request $request){
        $items = Item::leftJoin('brands','items.brand_id','brands.id')
            ->select(
                'items.id',
                'items.internal_id',
                'items.description',
                'brands.name',
                'items.has_plastic_bag_taxes'
            )
            ->where('items.internal_id', '=', $request->input('search'))
            ->orWhere(DB::raw("REPLACE(items.description, ' ', '')"), 'like', "%" .str_replace(' ','',$request->input('search')). "%")
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
                'internal_id' => $item->id,
                'description' => $item->description,
                'has_plastic_bag_taxes' => $item->has_plastic_bag_taxes,
                'name' => $item->name,
                'image_url' => $image,
            ];
        }

        return response()->json(['success'=>true,'data'=>$data], 200);
    }
}
