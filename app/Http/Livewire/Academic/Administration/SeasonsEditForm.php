<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicSeason;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class SeasonsEditForm extends Component
{
    public $season_id;
    public $description;
    public $state;
    public $season;

    public function mount($season_id){
        $this->season_id = $season_id;
        $this->season = AcademicSeason::find($season_id);

        $this->description = $this->season->description;
        $this->state = $this->season->state;
    }

    public function render()
    {
        return view('livewire.academic.administration.seasons-edit-form');
    }

    public function update(){
        $this->validate([
            'season_id' => 'required|unique:academic_seasons,id,'.$this->season_id,
            'description' => 'required|unique:academic_seasons,description,'.$this->season_id
        ]);

        if($this->state){
            AcademicSeason::where('state',1)->update(['state'=>0]);
        }

        $this->season->update([
            'id' => $this->season_id,
            'description' => $this->description,
            'state' => $this->state
        ]);

        $this->dispatchBrowserEvent('response_success_season', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
