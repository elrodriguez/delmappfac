<?php

namespace App\Http\Controllers\Onlineshop\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop\ShoItem;
use App\Models\Warehouse\Item;
use Illuminate\Http\Request;
use App\Models\OnlineShop\ShoItemGallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ItemsController extends Controller
{
    public function list(){

        return datatables($this->productsJoin())
            ->addColumn('gallery_url',function($row){
                return route('onlineshop_administration_products_gallery',$row->id);
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
            'sale_unit_price',
            'purchase_unit_price',
            'brands.name',
            DB::raw("(SELECT CONCAT('[',JSON_OBJECT('id',id,'title',title,'description',description,'color',color,'price',price,'stock',stock,'state',state),']') FROM sho_items WHERE item_id = items.id) AS sho_item")
        ])
        ->selectSub(function($query) {
            $query->from('inventory_kardex')->selectRaw('SUM(quantity) AS quantity')
                ->whereColumn('inventory_kardex.item_id','items.id');
        }, 'current_stock')
        //->whereIn('module_type', ['PUC', 'SAL', 'PAL'])
        ->orderBy('items.id','DESC');
    }

    public function saveItems(Request $request){
        $item_id = $request->post('item_id');
        $item_colors = $request->post('item_color');
        $sho_item_id = $request->post('sho_item_id');

        $exists = ShoItem::where('item_id',$item_id)->exists();
        $tit = '';
        $msg = '';
        $ico = 'success';
        $atc = '';

        if($exists){
            ShoItem::where('item_id',$item_id)
                ->update([
                    'title' => $request->post('online_title'),
                    'description' => $request->post('item_description'),
                    'color' => json_encode($item_colors),
                    'price' => $request->post('online_price'),
                    'stock' => $request->post('online_stock'),
                    'state' => ($request->post('item_state')?1:0),
                    'new_product' => ($request->post('new_product')?1:0),
                    'seo_url' => seo_url($request->post('online_title'))
                ]);
            
            

            if($request->file('file')){

                $files = $request->file('file');
                ShoItemGallery::where('item_id',$item_id)->update(['state'=>false]);

                foreach($files as $key => $file){
                    $name = $files[$key]->getClientOriginalName();
                    $files[$key]->storeAs('items/'.$item_id.'/', str_replace(' ','',$name),'public');
                    ShoItemGallery::create([
                        'shop_item_id' => $sho_item_id,
                        'item_id' => $item_id,
                        'url' => 'items/'.$item_id.'/'.$name,
                        'name' => str_replace(' ','',$name)
                    ]);
                }

            }
            $tit = Lang::get('messages.congratulations');
            $msg = Lang::get('messages.was_successfully_updated');
            $ico = 'success';
            $atc = 'update';
                
        }else{
            $shoItem = ShoItem::create([
                'item_id' => $item_id,
                'title' => $request->post('online_title'),
                'description' => $request->post('item_description'),
                'color' => json_encode($item_colors),
                'price' => $request->post('online_price'),
                'stock' => $request->post('online_stock'),
                'state' => ($request->post('item_state')?1:0),
                'new_product' => ($request->post('new_product')?1:0),
                'seo_url' => seo_url($request->post('online_title'))
            ]);
    
            if($request->file('file')){
                $files = $request->file('file');
                foreach($files as $key => $file){
                    $name = $files[$key]->getClientOriginalName();
                    $files[$key]->storeAs('items/'.$item_id.'/', str_replace(' ','',$name),'public');
                    ShoItemGallery::create([
                        'shop_item_id' => $shoItem->id,
                        'item_id' => $item_id,
                        'url' => 'items/'.$item_id.'/'.$name,
                        'name' => str_replace(' ','',$name)
                    ]);
                }
            }
            $tit = Lang::get('messages.congratulations');
            $msg = Lang::get('messages.successfully_registered');
            $ico = 'success';
            $atc = 'store';
        }
        return response()->json(['success'=>true,'msg'=>$msg,'tit'=>$tit,'ico'=>$ico,'act'=>$atc], 200);
    }

    public function searchProducts(Request $request){
        $products = Item::join('sho_items','items.id','sho_items.item_id')
            ->where('items.description','like','%'.$request->input('q').'%')
            ->select(
                'items.id AS value',
                'items.description AS text'
            )
            ->limit(100)
            ->get();

        return response()->json($products, 200);

    }
}
