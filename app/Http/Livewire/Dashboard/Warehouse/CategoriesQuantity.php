<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Master\ItemCategory;
use Livewire\Component;

class CategoriesQuantity extends Component
{
    public $total;

    public function mount(){
        $this->getCategoriesQuantity();
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.categories-quantity');
    }
    public function getCategoriesQuantity(){
        $this->total = ItemCategory::count();
    }
}
