<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\Curricula;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CurriculaEditForm extends Component
{
    public $curricula_id;
    public $description;
    public $state;
    public $academic_levels;
    public $academic_level_id;
    public $curricula;

    public function mount($curricula_id){
        $this->curricula_id = $curricula_id;
        $this->curricula = Curricula::find($curricula_id);

        $this->description = $this->curricula->description;
        $this->academic_level_id = $this->curricula->academic_level_id;
        $this->state = $this->curricula->state;
    }

    public function render()
    {
        $this->academic_levels = AcademicLevel::all();
        return view('livewire.academic.administration.curricula-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required'
        ]);

        if($this->state){
            if($this->academic_level_id){
                Curricula::where('state',1)->where('academic_level_id',$this->academic_level_id)->update(['state'=>0]);
            }else{
                Curricula::where('state',1)->whereNull('academic_level_id')->update(['state'=>0]);
            }
        }

        $this->curricula->update([
            'description' => $this->description,
            'state' => $this->state,
            'academic_level_id' => $this->academic_level_id
        ]);

        $this->dispatchBrowserEvent('response_success_curricula', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
