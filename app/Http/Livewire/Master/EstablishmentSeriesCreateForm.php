<?php

namespace App\Http\Livewire\Master;

use App\Models\Catalogue\DocumentType;
use App\Models\Master\Serie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EstablishmentSeriesCreateForm extends Component
{
    public $establisment_id;
    public $document_types;
    public $serie;
    public $correlative;
    public $state = 1;
    public $document_type;

    public function mount($establisment_id){
        $this->establisment_id = $establisment_id;
    }

    public function render()
    {
        $this->document_types = DocumentType::all();
        return view('livewire.master.establishment-series-create-form');
    }

    public function store(){
        $this->validate([
            'serie' => 'required|unique:series,id',
            'correlative' => 'required|numeric',
            'document_type' => 'required'
        ]);

        Serie::create([
            'id' => strtoupper($this->serie),
            'correlative' => $this->correlative,
            'establishment_id' => $this->establisment_id,
            'user_id' => Auth::id(),
            'document_type_id' => $this->document_type,
            'state' => ($this->state?$this->state:0)
        ]);

        $this->document_types = null;
        $this->serie = null;
        $this->correlative = null;
        $this->state = 1;

        $this->dispatchBrowserEvent('response_series_store', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
