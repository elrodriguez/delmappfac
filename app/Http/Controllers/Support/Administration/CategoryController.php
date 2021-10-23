<?php

namespace App\Http\Controllers\Support\Administration;

use App\Http\Controllers\Controller;
use App\Models\Support\Administration\SupCategory;
use App\Models\Support\Helpdesk\SupTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    public function list(){
        return datatables($this->categoryJoin())
            ->addColumn('edit_url', function($row){
                return route('support_administration_category_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('support_administration_category_delete', $row->id);
            })
            ->make(true);
    }
    public function categoryJoin(){
        $strDays = Lang::get('messages.days');
        $strHours = Lang::get('messages.hours');
        $strMinutes = Lang::get('messages.minutes');
        return SupCategory::query()
            ->leftJoin('sup_categories AS t2','t2.id','sup_categories.sup_category_id')
            ->select([
                'sup_categories.id',
                DB::raw('IFNULL(t2.short_description,sup_categories.short_description) AS t2_short_description'),
                'sup_categories.state',
                'sup_categories.sup_category_id',
                DB::raw('IF(t2.short_description IS NULL,NULL,sup_categories.short_description) AS short_description'),
                DB::raw('CONCAT(sup_categories.days," '.$strDays.' ",sup_categories.hours," '.$strHours.' ",sup_categories.minutes," '.$strMinutes.'") AS atention_time')
            ]);
    }

    public function destroy($id){
        $exists = SupTicket::where('sup_category_id',$id)->exists();
        if($exists){
            return response()->json(['success'=>false,'msg'=>Lang::get('messages.msg_not_peptra')], 200);
        }else{
            $supcategory = SupCategory::find($id);

            $user = Auth::user();
            $activity = new Activity;
            $activity->causedBy($user);
            $activity->routeOn(route('support_administration_category_delete', $id));
            $activity->dataOld($supcategory);
            $activity->logType('delete');
            $activity->log('Eliminó la categoria');
            $activity->save();

            $supcategory->delete();

            return response()->json(['success'=>true,'msg'=>Lang::get('messages.was_successfully_removed')], 200);
        }
    }
}
