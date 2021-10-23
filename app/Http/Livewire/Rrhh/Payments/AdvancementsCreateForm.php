<?php

namespace App\Http\Livewire\Rrhh\Payments;

use App\Models\RRHH\Administration\Concept;
use App\Models\RRHH\Administration\Employee;
use App\Models\RRHH\Payments\EmployeeConcept;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AdvancementsCreateForm extends Component
{
    public $amount;
    public $person_id;
    public $observations;
    public $concept_id;
    public $concepts;

    public function render()
    {
        $this->concepts = Concept::all();
        return view('livewire.rrhh.payments.advancements-create-form');
    }

    public function changeAmount(){
        $this->amount = Concept::where('id',$this->concept_id)->value('percentage');
    }
    
    public function store(){
        $this->validate([
            'person_id' => 'required',
            'observations' => 'required|max:255',
            'amount' => 'required|numeric|between:0,99999999999.99'
        ]);
        $employee = Employee::where('person_id',$this->person_id)->first();
        EmployeeConcept::create([
            'employee_id' => $employee->id,
            'person_id' => $this->person_id,
            'concept_id' => $this->concept_id,
            'amount' => $this->amount,
            'user_id' => Auth::id(),
            'observations' => $this->observations
        ]);
        $this->person_id =  null;
        $this->amount = null;
        $this->observations = null;
        $this->concept_id = null;
        $this->dispatchBrowserEvent('response_success_advancement', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
