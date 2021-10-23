<?php

namespace App\Http\Livewire\Dashboard;

use App\Http\Controllers\warehouse\ProducctionController;
use App\Models\Warehouse\Sack;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Fishery extends Component
{
    public $total_sacks;
    public $boxes;

    public function mount(){
        $this->total_sacks = Sack::where('weight',20)
            ->select(DB::raw('SUM(stock) as stock'))
            ->first();
            $production = new ProducctionController;
        $this->boxes = $production->boxtodaybybrands();
    }
    public function render()
    {
        return view('livewire.dashboard.fishery');
    }
}
