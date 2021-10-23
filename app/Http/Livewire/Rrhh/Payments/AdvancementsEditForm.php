<?php

namespace App\Http\Livewire\Rrhh\Payments;

use App\Models\Master\Person;
use App\Models\RRHH\Payments\EmployeeConcept;
use App\Models\RRHH\Administration\Concept;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AdvancementsEditForm extends Component
{
    public $advancement_id;
    public $person_name;
    public $amount;
    public $state;
    public $observations;
    public $concept_id;
    public $concepts;

    public function mount($advancement_id){
        $this->advancement_id = $advancement_id;
        $advancement = EmployeeConcept::find($advancement_id);
        $person = Person::find($advancement->person_id);
        $this->amount = $advancement->amount;
        $this->person_name = $person->trade_name;
        $this->state = $advancement->state;
        $this->concept_id = $advancement->concept_id;
        $this->observations = $advancement->observations;
    }
    public function render()
    {
        $this->concepts = Concept::all();
        return view('livewire.rrhh.payments.advancements-edit-form');
    }

    public function changeAmount(){
        $this->amount = Concept::where('id',$this->concept_id)->value('percentage');
    }

    public function update(){
        $this->validate([
            'amount' => 'required|numeric|between:0,99999999999.99'
        ]);
        if($this->state == 1){
            $this->dispatchBrowserEvent('response_success_advancement', ['title'=>Lang::get('messages.failed_process'),'message' => Lang::get('messages.can_no_longer_perform_this_action'),'state'=>'error']);
        }else{
            EmployeeConcept::where('id',$this->advancement_id)->update([
                'amount' => $this->amount,
                'user_id' => Auth::id(),
                'concept_id' => $this->concept_id,
                'observations' => $this->observations
            ]);
            $this->dispatchBrowserEvent('response_success_advancement', ['title'=>Lang::get('messages.congratulations'),'message' => Lang::get('messages.was_successfully_updated'),'state'=>'success']);
        }

    }
}
