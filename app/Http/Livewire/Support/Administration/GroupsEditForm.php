<?php

namespace App\Http\Livewire\Support\Administration;

use App\Models\Support\Administration\SupServiceArea;
use App\Models\Support\Administration\SupServiceAreaGroup;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class GroupsEditForm extends Component
{
    public $areas;
    public $area_id;
    public $description;
    public $state = true;
    public $group;
    public $group_id;

    public function mount($group_id){
        $this->group_id = $group_id;
        $this->areas = SupServiceArea::where('state',1)->get();
        $this->group = SupServiceAreaGroup::find($group_id);

        $this->area_id = $this->group->sup_service_area_id;
        $this->description = $this->group->description;
        $this->state = $this->group->state;

    }

    public function render()
    {
        return view('livewire.support.administration.groups-edit-form');
    }

    public function update(){
        $this->validate([
            'area_id' => 'required',
            'description' => 'required|max:255'
        ]);

        $activity = new Activity;
        $activity->dataOld(SupServiceAreaGroup::find($this->group_id));

        $this->group->update([
            'sup_service_area_id' => $this->area_id,
            'description' => $this->description,
            'state' => ($this->state?$this->state:false)
        ]);

        $user = Auth::user();

        $activity->modelOn(SupServiceAreaGroup::class,$this->group->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_groups_create'));
        $activity->componentOn('support.administration.groups-create-form');
        $activity->dataUpdated($this->group);
        $activity->logType('update');
        $activity->log('Actualizo los datos del grupo');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_supservice_area_group_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
