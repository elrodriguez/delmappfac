<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Package;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class PackagesEditForm extends Component
{
    public $package_id;
    public $description;
    public $state;

    public function mount($package_id){
        $this->package_id = $package_id;
        $package = Package::find($this->package_id);
        $this->description = $package->description;
        $this->state = $package->state;
    }
    public function render()
    {
        return view('livewire.academic.administration.packages-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required|max:255'
        ]);

        Package::where('id',$this->package_id)->update([
            'description' => $this->description,
            'state' => $this->state
        ]);
        $this->dispatchBrowserEvent('response_success_packages_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
