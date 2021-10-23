<?php

namespace App\Http\Livewire\Dashboard\Academic;

use App\Models\Master\Document;
use Livewire\Component;

class NumberDocuments extends Component
{
    public $quantity_document;

    public function mount(){
        $this->quantity_document = Document::where('module','ACD')
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard.academic.number-documents');
    }
}
