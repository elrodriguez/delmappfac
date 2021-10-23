<?php

namespace App\Http\Livewire\Support\Administration;

use App\Models\Support\Administration\SupServiceArea;
use App\Models\Support\Administration\SupServiceAreaGroup;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class GroupsCreateForm extends Component
{
    public $areas;
    public $area_id;
    public $description;
    public $state = true;

    public function mount(){
        $this->areas = SupServiceArea::where('state',1)->get();
    }
    public function render()
    {
        return view('livewire.support.administration.groups-create-form');
    }

    public function store(){
        $this->validate([
            'area_id' => 'required',
            'description' => 'required|max:255'
        ]);

        $group = SupServiceAreaGroup::create([
            'sup_service_area_id' => $this->area_id,
            'description' => $this->description,
            'state' => ($this->state?$this->state:false)
        ]);

        $this->area_id = null;
        $this->description = null;
        $this->state = true;

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupServiceAreaGroup::class,$group->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_administration_groups_create'));
        $activity->componentOn('support.administration.groups-create-form');
        $activity->dataOld($group);
        $activity->logType('create');
        $activity->log('Registro un nuevo grupo');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_supservice_area_group_store', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
