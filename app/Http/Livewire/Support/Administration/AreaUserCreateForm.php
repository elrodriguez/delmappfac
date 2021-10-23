<?php

namespace App\Http\Livewire\Support\Administration;

use App\Models\Support\Administration\SupServiceArea;
use App\Models\Support\Administration\SupServiceAreaGroup;
use App\Models\Support\Administration\SupServiceAreaUser;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AreaUserCreateForm extends Component
{
    public $user_id;
    public $area_id;
    public $areas;
    public $group_id;
    public $groups = [];

    public function mount(){
        $this->areas = SupServiceArea::where('state',1)->get();

    }

    public function render()
    {
        return view('livewire.support.administration.area-user-create-form');
    }

    public function loadGroup(){
        $this->groups = SupServiceAreaGroup::where('state',1)
            ->where('sup_service_area_id',$this->area_id)
            ->get();
    }
    public function store(){

        $this->validate([
            'user_id' => 'required|unique:sup_service_area_users,user_id',
            'area_id' => 'required'
        ]);

        $areauser = SupServiceAreaUser::create([
            'sup_service_area_id' => $this->area_id,
            'user_id' => $this->user_id,
            'sup_service_area_group_id' => $this->group_id
        ]);

        $this->area_id = null;
        $this->user_id = null;
        $this->group_id = null;

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupServiceAreaUser::class,$areauser->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_area_user_create'));
        $activity->componentOn('support.administration.area-user-create-form');
        $activity->dataOld($areauser);
        $activity->logType('create');
        $activity->log('Asigno usuario a un nivel');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_supservice_area_user_store', ['message' => Lang::get('messages.successfully_registered')]);

    }
}
