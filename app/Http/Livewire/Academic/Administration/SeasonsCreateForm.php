<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicSeason;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class SeasonsCreateForm extends Component
{
    public $description;
    public $state = 0;
    public $season_id;

    public function render()
    {
        return view('livewire.academic.administration.seasons-create-form');
    }

    public function store(){
        $this->validate([
            'season_id' => 'required|unique:academic_seasons,id',
            'description' => 'required|unique:academic_seasons,description'
        ]);

        if($this->state){
            AcademicSeason::where('state',1)->update(['state'=>0]);
        }

        AcademicSeason::create([
            'id' => $this->season_id,
            'description' => $this->description,
            'state' => $this->state
        ]);

        $this->description = null;
        $this->state = 0;
        $this->season_id = null;

        $this->dispatchBrowserEvent('response_success_season', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
