<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Models\Warehouse\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class BrandsEditForm extends Component
{
    public $name;
    public $brand_id;

    public function mount($id){
        $this->brand_id = $id;
        $brand = Brand::find($this->brand_id);
        $this->name  = $brand->name;
    }
    public function render()
    {
        return view('livewire.logistics.catalogs.brands-edit-form');
    }

    public function update(){
        $this->validate([
            'name' => 'required'
        ]);

        Brand::where('id',$this->brand_id)->update([
            'name' => $this->name
        ]);
        $this->dispatchBrowserEvent('response_brands_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
