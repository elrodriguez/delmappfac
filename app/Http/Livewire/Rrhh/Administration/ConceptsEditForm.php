<?php

namespace App\Http\Livewire\Rrhh\Administration;

use Livewire\Component;
use App\Models\RRHH\Administration\Concept;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ConceptsEditForm extends Component
{
    public $concept_id;
    public $description;
    public $percentage;
    public $operation;

    public function mount($id){
        $this->concept_id = $id;
        $concept = Concept::find($this->concept_id);
        $this->description  = $concept->description;
        $this->percentage  = $concept->percentage;
        $this->operation  = $concept->operation;
    }
    public function render()
    {
        return view('livewire.rrhh.administration.concepts-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required',
            'operation' => 'required',
        ]);

        Concept::where('id',$this->concept_id)->update([
            'description' => $this->description,
            'percentage' => $this->percentage,
            'operation' => $this->operation
        ]);
        $this->dispatchBrowserEvent('response_concepts_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
