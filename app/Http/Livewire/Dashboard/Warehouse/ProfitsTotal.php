<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\Master\Document;
use Livewire\Component;

class ProfitsTotal extends Component
{
    public $total;

    public function render()
    {
        $this->sales();
        return view('livewire.dashboard.warehouse.profits-total');
    }

    public function sales(){
        $documents = Document::whereIn('document_type_id', ['01', '03'])
                    ->where(function($query){
                        $query->whereNotIn('state_type_id', ['11', '13']);
                    })
                    ->sum('total');


        $this->total = ($documents);
    }
}
