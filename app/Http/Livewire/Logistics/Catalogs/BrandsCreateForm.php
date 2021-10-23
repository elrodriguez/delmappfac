<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Warehouse\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class BrandsCreateForm extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.logistics.catalogs.brands-create-form');
    }

    public function store(){
        $this->validate([
            'name' => 'required'
        ]);

        Brand::create([
            'name' => $this->name
        ]);
        $this->clearForm();

        $this->dispatchBrowserEvent('response_brands_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    private function clearForm(){
        $this->name = null;
    }
}
