<?php

namespace App\Http\Controllers\Onlineshop\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop\ShoPromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;

class PromotionsController extends Controller
{
    public function list(){
        return datatables(ShoPromotion::query())
            ->addColumn('edit_url', function($row){
                return route('onlineshop_administration_promotions_edit', $row->id);
            })->addColumn('delete_url', function($row){
                return route('onlineshop_administration_promotions_delete', $row->id);
            })->addColumn('add_items_url', function($row){
                return route('onlineshop_administration_promotions_items', $row->id);
            })
            ->editColumn('image', function($row){
                $file = 'storage/'.$row->image;
                if(file_exists(public_path($file))){
                    return asset('storage/'.$row->image);
                }else{
                    return ui_avatars_url($row->title,50,'none',0);
                }
            })
            ->make(true);
    }

    public function destroy($id){
        try {
            
            $tit = Lang::get('messages.removed');
            $msg = Lang::get('messages.was_successfully_removed');
            $ico = 'success';

            $user = Auth::user();
            $activity = new Activity;
            $activity->causedBy($user);
            $activity->routeOn(route('onlineshop_administration_promotions_delete', $id));
            $activity->dataOld(ShoPromotion::find($id));
            $activity->logType('delete');
            $activity->log('Eliminó la promocion');
            
            ShoPromotion::find($id)->delete();
            $activity->save();

        } catch (\Illuminate\Database\QueryException $e) {
            $tit = Lang::get('messages.error');
            $msg = 'Registro relacionado, imposible de eliminar';
            $ico = 'error';
        }

        return response()->json(['success'=>true,'msg'=>$msg,'tit'=>$tit,'ico'=>$ico], 200);
    }
}
