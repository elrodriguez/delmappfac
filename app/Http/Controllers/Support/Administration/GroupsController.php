<?php

namespace App\Http\Controllers\Support\Administration;

use App\Http\Controllers\Controller;
use App\Models\Support\Administration\SupServiceAreaGroup;
use App\Models\Support\Administration\SupServiceAreaUser;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function list(){
        return datatables($this->groupJoin())
            ->addColumn('edit_url', function($row){
                return route('support_administration_groups_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('support_administration_groups_delete', $row->id);
            })
            ->make(true);
    }
    public function groupJoin(){
        return SupServiceAreaGroup::query()
            ->join('sup_service_areas','sup_service_area_groups.sup_service_area_id','sup_service_areas.id')
            ->select(
                'sup_service_area_groups.id',
                'sup_service_areas.description AS area_description',
                'sup_service_area_groups.description AS group_description',
                'sup_service_area_groups.state'
            );
    }

    public function destroy($id){
        $exists = SupServiceAreaUser::where('sup_service_area_group_id',$id)->exists();
        if($exists){
            return response()->json(['success'=>false,'msg'=>Lang::get('messages.msg_not_peptra')], 200);
        }else{
            $groups = SupServiceAreaGroup::find($id);

            $user = Auth::user();
            $activity = new Activity;
            $activity->causedBy($user);
            $activity->routeOn(route('support_administration_groups_delete', $id));
            $activity->dataOld($groups);
            $activity->logType('delete');
            $activity->log('Eliminó la categoria');
            $activity->save();

            $groups->delete();

            return response()->json(['success'=>true,'msg'=>Lang::get('messages.was_successfully_removed')], 200);
        }
    }
}
