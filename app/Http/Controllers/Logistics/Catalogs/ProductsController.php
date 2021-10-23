<?php

namespace App\Http\Controllers\Logistics\Catalogs;

use App\Http\Controllers\Controller;
use App\Imports\ItemsImport;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ProductsController extends Controller
{
    public function list(){

        return datatables($this->productsJoin())
            ->addColumn('edit_url', function($row){
                return route('logistics_catalogs_products_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('logistics_catalogs_products_delete', $row->id);
            })
            ->editColumn('image_url',function($row){
                $file = 'storage/items/'.$row->id.'.jpg';
                if(file_exists(public_path($file))){
                    return asset('storage/items/'.$row->id.'.jpg');
                }else{
                    return ui_avatars_url($row->description,50,'none',0);
                }
            })
            ->make(true);
    }

    public function productsJoin(){
        return Item::query()->leftjoin('brands','items.brand_id','brands.id')
        ->select([
            'items.id',
            'internal_id',
            'description',
            'stock',
            'stock_min',
            'sale_unit_price',
            'purchase_unit_price',
            'brands.name'
        ])
        ->selectSub(function($query) {
            $query->from('inventory_kardex')->selectRaw('SUM(quantity) AS quantity')
                ->whereColumn('inventory_kardex.item_id','items.id');
        }, 'current_stock')
        //->whereIn('module_type', ['PUC', 'SAL', 'PAL'])
        ->orderBy('items.id','DESC');
    }
    public function destroy($id){
        $item = Item::find($id);
        if($item){
            $item->delete();
        }
        return response()->json(['success'=>true,'name'=>$item->description], 200);
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $import = new ItemsImport();

            if(Excel::import($import, $file)) {
                return response()->json('success', 200);
            } else {
                return response()->json('error', 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 400);
        }

    }
}
