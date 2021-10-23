<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Warehouse\Brand;
use Livewire\Component;

class BrandsQuantity extends Component
{
    public $total;

    public function mount(){
        $this->getBrandsQuantity();
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.brands-quantity');
    }
    public function getBrandsQuantity(){
        $this->total = Brand::count();
    }
}
