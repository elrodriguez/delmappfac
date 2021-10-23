<?php

namespace App\Http\Controllers\Support\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\User;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ServiceAreaUsersController extends Controller
{
    public function list(){
        return datatables($this->areaUsersJoin())
            ->addColumn('delete_url', function($row){
                return route('support_administration_area_users_delete', $row->id);
            })
            ->make(true);
    }
    public function areaUsersJoin(){
        return SupServiceAreaUser::query()
            ->join('users','sup_service_area_users.user_id','users.id')
            ->join('sup_service_areas','sup_service_area_users.sup_service_area_id','sup_service_areas.id')
            ->select(
                'sup_service_area_users.id',
                'users.name',
                'users.email',
                'sup_service_areas.description'
            );
    }

    public function searchUser(){
        return datatables()->eloquent($this->userQuery())
            ->filter(function ($query) {
                if (request()->has('search')) {
                    $query->where('people.number', 'like', "%" . request('search') . "%")
                    ->orWhere('people.trade_name', 'like', "%" . request('search') . "%");
                }
            })
            ->editColumn('profile_photo_path', function($row){
                if($row->profile_photo_path){
                    return $row->profile_photo_path;
                }else{
                    return ui_avatars_url($row->name,50,'none');
                }
            })
            ->toJson();
    }

    private function userQuery(){
        return  User::query()->join('people','users.person_id','people.id')
        ->select(
            'users.id',
            'users.name',
            'users.profile_photo_path',
            'people.trade_name',
            'people.number'
        )
        ->limit(100);
    }

    public function destroy($id){
        $areauser = SupServiceAreaUser::find($id);
        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_area_users_delete', $id));
        $activity->dataOld($areauser);
        $activity->logType('delete');
        $activity->log('Eliminó asignación de usuario a su nivel');
        $activity->save();

        $areauser->delete();

        return response()->json(['success'=>true,'msg'=>Lang::get('messages.was_successfully_removed')], 200);

    }
}
