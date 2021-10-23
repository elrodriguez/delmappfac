<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Master\Supplier;
use Livewire\Component;

class SuppliersQuantity extends Component
{
    public $total;

    public function mount(){
        $this->getSuppliersQuantity();
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.suppliers-quantity');
    }

    public function getSuppliersQuantity(){
        $this->total = Supplier::count();
    }

}
