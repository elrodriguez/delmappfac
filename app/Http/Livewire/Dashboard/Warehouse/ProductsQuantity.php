<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Warehouse\Item;
use Livewire\Component;

class ProductsQuantity extends Component
{
    public $total;

    public function mount(){
        $this->getProductsQuantity();
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.products-quantity');
    }
    public function getProductsQuantity(){
        $this->total = Item::count();
    }
}
