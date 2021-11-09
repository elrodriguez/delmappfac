<?php

namespace App\Http\Livewire\Market\Sales;

use Livewire\Component;
use App\Models\Catalogue\DocumentType;
use App\Models\Master\Person;
use App\Models\Master\Document;

class SearchWeb extends Component
{
    public $document_types;
    public $document_type_id;
    public $serie;
    public $number;
    public $f_issuance;
    public $total_amount;
    public $client_number;
    public $document = [];

    public function render()
    {
        $this->document_types = DocumentType::whereIn('id',['01','03'])->get();
        return view('livewire.market.sales.search-web');
    }

    public function searhDocument(){
        
        $this->validate([
            'document_type_id' => 'required',
            'serie' => 'required',
            'number' => 'required',
            'f_issuance' => 'required',
            'total_amount' => 'required',
            'client_number' => 'required'
        ]);

        $msg = '';

        $customer = Person::where('number', $this->client_number)
                            ->join('customers','people.id','customers.person_id')
                            ->select('people.id')
                            ->first();
        if (!$customer) {
            $msg = 'El número del cliente ingresado no se encontró en la base de datos.';
            $this->dispatchBrowserEvent('response_sales_search', ['tit'=>'Error','ico'=>'error','message' => $msg]);
        }

        list($d,$m,$Y) = explode('/',$this->f_issuance);
        $date = $Y.'-'.$m.'-'.$d;

        $document = Document::where('date_of_issue', $date)
                            ->where('document_type_id', $this->document_type_id)
                            ->where('series', strtoupper($this->serie))
                            ->where('number', (int) $this->number)
                            ->where('total', '2.00')
                            ->where('customer_id', $customer->id)
                            ->first();

        if ($document) {
            $this->document = $document;
        } else {
            $msg = 'El documento no fue encontrado.';
            $this->dispatchBrowserEvent('response_sales_search', ['tit'=>'Error','ico'=>'error','msg' => $msg]);
        }
    }
}
