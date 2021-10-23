<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Discount;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class DiscountCreateForm extends Component
{
    public $percentage;
    public $description;
    public $state;

    public function render()
    {
        return view('livewire.academic.administration.discount-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|max:255',
            'percentage' => 'required|numeric|between:0,99999999999.99',
        ]);

        Discount::create([
            'description' => $this->description,
            'percentage' => $this->percentage,
            'number' => 0,
            'module' => 'ACD',
            'state' => $this->state
        ]);

        $this->clearform();
        $this->dispatchBrowserEvent('response_success_discount', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearform(){
        $this->percentage = null;
        $this->description = null;
        $this->state = null;
    }
}
