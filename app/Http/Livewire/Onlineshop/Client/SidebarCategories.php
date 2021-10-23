<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\Master\ItemCategory;
use Livewire\Component;

class SidebarCategories extends Component
{
    public $categories;

    public function mount(){
        $this->categories = ItemCategory::where('state',true)->get();
    }

    public function render()
    {
        return view('livewire.onlineshop.client.sidebar-categories');
    }
}
