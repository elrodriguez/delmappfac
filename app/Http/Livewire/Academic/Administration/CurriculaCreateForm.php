<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\Curricula;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CurriculaCreateForm extends Component
{
    public $description;
    public $state;
    public $academic_levels;
    public $academic_level_id;

    public function render()
    {
        $this->academic_levels = AcademicLevel::all();
        return view('livewire.academic.administration.curricula-create-form');
    }

    public function store(){
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

        Curricula::create([
            'description' => $this->description,
            'state' => ($this->state?$this->state:0),
            'academic_level_id' => $this->academic_level_id
        ]);

        $this->description = null;
        $this->academic_level_id = null;
        $this->state = null;

        $this->dispatchBrowserEvent('response_success_curricula', ['message' => Lang::get('messages.successfully_registered')]);
    }

}
