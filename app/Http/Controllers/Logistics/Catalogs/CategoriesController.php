<?php

namespace App\Http\Controllers\Logistics\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Master\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class CategoriesController extends Controller
{
    public function list(){
        return datatables(ItemCategory::query())
        ->addColumn('edit_url', function($row){
            return route('logistics_catalogs_categories_edit', $row->id);
        })
        ->addColumn('delete_url', function($row){
            return route('logistics_catalogs_categories_delete', $row->id);
        })
        ->make(true);
    }

    public function destroy($id){

        try {
            ItemCategory::find($id)->delete();
            $tit = Lang::get('messages.removed');
            $msg = Lang::get('messages.was_successfully_removed');
            $ico = 'success';
        } catch (\Illuminate\Database\QueryException $e) {
            $tit = Lang::get('messages.error');
            $msg = Lang::get('messages.msg_not_peptra');
            $ico = 'error';
        }
        
        return response()->json(['success'=>true,'message'=>$msg,'title'=>$tit,'icon'=>$ico], 200);

    }
}
