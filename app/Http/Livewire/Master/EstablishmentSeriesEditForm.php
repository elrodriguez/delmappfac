<?php

namespace App\Http\Livewire\Master;

use App\Models\Catalogue\DocumentType;
use App\Models\Master\Serie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EstablishmentSeriesEditForm extends Component
{
    public $establisment_id;
    public $document_types;
    public $series;
    public $serie_id;
    public $correlative;
    public $state = 1;
    public $document_type;

    public function mount($establisment_id,$serie_id){
        $this->establisment_id = $establisment_id;
        $this->serie_id = $serie_id;
        $this->series = Serie::find($this->serie_id);
        $this->correlative = $this->series->correlative;
        $this->document_type = $this->series->document_type_id;
        $this->state = $this->series->state;
    }

    public function render()
    {
        $this->document_types = DocumentType::all();
        return view('livewire.master.establishment-series-edit-form');
    }

    public function store(){
        $this->validate([
            'serie_id' => 'required|unique:series,id,'.$this->serie_id,
            'correlative' => 'required|numeric',
            'document_type' => 'required'
        ]);

        $this->series->update([
            'id' => strtoupper($this->serie_id),
            'correlative' => $this->correlative,
            'establishment_id' => $this->establisment_id,
            'user_id' => Auth::id(),
            'document_type_id' => $this->document_type,
            'state' => ($this->state?$this->state:0)
        ]);

        $this->dispatchBrowserEvent('response_series_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
