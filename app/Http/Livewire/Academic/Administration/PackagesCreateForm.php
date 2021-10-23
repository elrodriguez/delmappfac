<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Package;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class PackagesCreateForm extends Component
{
    public $description;
    public $state;

    public function render(){
        return view('livewire.academic.administration.packages-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|max:255'
        ]);

        Package::create([
            'description' => $this->description,
            'module' => 'ACD',
            'state' => ($this->state?$this->state:0)
        ]);

        $this->clearform();
        $this->dispatchBrowserEvent('response_success_packages', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearform(){
        $this->description = null;
        $this->state = null;
    }
}
