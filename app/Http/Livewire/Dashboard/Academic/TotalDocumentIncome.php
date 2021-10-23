<?php

namespace App\Http\Livewire\Dashboard\Academic;

use App\Models\Master\Document;
use Livewire\Component;

class TotalDocumentIncome extends Component
{
    public $total_document;

    public function mount(){
        $this->total_document = Document::whereIn('state_type_id',['01','03','05'])
            ->where('module','ACD')
            ->sum('total');
    }

    public function render()
    {
        return view('livewire.dashboard.academic.total-document-income');
    }
}
