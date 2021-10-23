<?php

namespace App\Http\Controllers\Logistics\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class BrandsController extends Controller
{
    public function list(){
         return datatables($this->brandsJoin())
            ->addColumn('edit_url', function($row){
                return route('logistics_catalogs_brands_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('logistics_catalogs_brands_delete', $row->id);
            })
            ->make(true);
        
    }
    public function brandsJoin(){
        return Brand::query()->select([
            'id',
            'name'
        ]);
    }
    public function destroy($id){
        try {
            Brand::find($id)->delete();
            $tit = Lang::get('messages.removed');
            $msg = Lang::get('messages.was_successfully_removed');
            $ico = 'success';
        } catch (\Illuminate\Database\QueryException $e) {
            $tit = Lang::get('messages.error');
            $msg = 'Registro relacionado, imposible de eliminar';
            $ico = 'error';
        }

        return response()->json(['success'=>true,'msg'=>$msg,'tit'=>$tit,'ico'=>$ico], 200);
    }
}
