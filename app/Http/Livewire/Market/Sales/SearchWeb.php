<?php

namespace App\Http\Livewire\Market\Sales;

use Livewire\Component;
use App\Models\Catalogue\DocumentType;

class SearchWeb extends Component
{
    public $document_types;

    public function render()
    {
        $this->document_types = DocumentType::whereIn('id',['01','03'])->get();
        return view('livewire.market.sales.search-web');
    }
}
