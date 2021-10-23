<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use App\Models\Master\Establishment;
use App\Models\Warehouse\Warehouse;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class WarehouseEditForm extends Component
{
    public $description;
    public $establishment_id;
    public $establishments = [];
    public $warehouse_id;
    public $warehouse;

    public function mount($warehouse_id){
        $this->warehouse_id = $warehouse_id;
        $this->warehouse = Warehouse::find($warehouse_id);
        $this->description = $this->warehouse->description;
        $this->establishment_id = $this->warehouse->establishment_id;
    }
    public function render()
    {
        $this->establishments = Establishment::all();
        return view('livewire.logistics.warehouse.warehouse-edit-form');
    }

    public function update(){
        $this->validate([
            'description' => 'required|max:255',
            'establishment_id' => 'required'
        ]);

        $this->warehouse->update([
            'establishment_id' => $this->establishment_id,
            'description' => $this->description
        ]);
        $this->dispatchBrowserEvent('response_warehouse_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
