<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Discount;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class DiscountEditForm extends Component
{
    public $discount_id;
    public $percentage;
    public $description;
    public $state;

    public function mount($discount_id){
        $this->discount_id = $discount_id;

        $discount = Discount::find($this->discount_id);
        $this->description = $discount->description;
        $this->percentage = $discount->percentage;
        $this->state = $discount->state;

    }

    public function render()
    {
        return view('livewire.academic.administration.discount-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required|max:255',
            'percentage' => 'required|numeric|between:0,99999999999.99',
        ]);

        Discount::where('id',$this->discount_id)->update([
            'description' => $this->description,
            'percentage' => $this->percentage,
            'state' => $this->state
        ]);

        $this->dispatchBrowserEvent('response_success_discount', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
