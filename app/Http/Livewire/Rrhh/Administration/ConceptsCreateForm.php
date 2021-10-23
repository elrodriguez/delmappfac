<?php

namespace App\Http\Livewire\Rrhh\Administration;

use Livewire\Component;
use App\Models\RRHH\Administration\Concept;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ConceptsCreateForm extends Component
{

    public $description;
    public $percentage;
    public $operation;

    public function render()
    {
        return view('livewire.rrhh.administration.concepts-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required',
            'operation' => 'required',
        ]);

        Concept::create([
            'description' => $this->description,
            'percentage' => $this->percentage,
            'operation' => $this->operation
        ]);
        $this->clearForm();
        $this->dispatchBrowserEvent('response_concepts_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    private function clearForm(){
        $this->description = null;
        $this->percentage = null;
        $this->operation = 0;
    }
}
