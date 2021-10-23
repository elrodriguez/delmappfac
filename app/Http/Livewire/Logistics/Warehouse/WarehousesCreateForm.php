<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use App\Models\Master\Establishment;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class WarehousesCreateForm extends Component
{
    public $description;
    public $establishment_id;
    public $establishments = [];

    public function render()
    {
        $this->establishments = Establishment::all();
        return view('livewire.logistics.warehouse.warehouses-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|max:255',
            'establishment_id' => 'required'
        ]);

        Warehouse::create([
            'establishment_id' => $this->establishment_id,
            'description' => $this->description
        ]);
        $this->establishment_id = null;
        $this->description = null;
        $this->dispatchBrowserEvent('response_warehouse_store', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
