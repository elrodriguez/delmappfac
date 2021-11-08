<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Http\Controllers\Master\UbigeoController;
use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use App\Models\Master\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ProvidersCreateForm extends Component
{
    public $identity_document_type_id;
    public $number;
    public $birth_date = null;
    public $marital_state = null;
    public $name;
    public $last_paternal;
    public $last_maternal;
    public $email;
    public $trade_name;
    public $address;
    public $telephone;
    public $ubigeo;
    public $country_id = 'PE';
    public $sex = 1 ;
    public $place_birth = null;
    public $identity_document_types = [];
    public $countries = [];
    public $ubigeos = [];
    public $time_arrival;


    public function mount(){
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
    }
    public function render(){
        $this->countries = DB::table('countries')->where('active',1)->get();

        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();

        return view('livewire.logistics.catalogs.providers-create-form');
    }

    public function store(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric|unique:people,number',
            'name' => 'required|min:3',
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'time_arrival' => 'required'

        ]);

        /* list($d,$m,$y) = explode('/',$this->birth_date);
        $birth_date = $y.'-'.$m.'-'.$d; */
        list($dp,$pv,$ds) = explode('*',$this->ubigeo);

        $provider = Person::create([
            'type' => 'suppliers',
            'identity_document_type_id' => $this->identity_document_type_id,
            'number' => $this->number,
            'name' => $this->name,
            'trade_name' => ($this->trade_name==null?$this->name.' '.$this->last_paternal.' '.$this->last_maternal:$this->trade_name),
            'country_id' => $this->country_id,
            'department_id' => $dp,
            'province_id' => $pv,
            'district_id' => $ds,
            'address' => $this->address,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'last_paternal' => $this->last_paternal,
            'last_maternal' => $this->last_maternal,
            'sex' => $this->sex,
            'marital_state' => $this->marital_state,
            'birth_date' => $this->birth_date,
            'place_birth' => $this->place_birth
        ]);

        Supplier::create([
            'person_id' => $provider->id,
            'time_arrival' => $this->time_arrival
        ]);

        PersonTypeDetail::create([
            'person_id' => $provider->id,
            'person_type_id' => 2
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('response_providers_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    private function resetInput(){
        $this->identity_document_type_id = null;
        $this->number = null;
        $this->birth_date = null;
        $this->marital_state = null;
        $this->name = null;
        $this->last_paternal = null;
        $this->last_maternal = null;
        $this->email = null;
        $this->trade_name = null;
        $this->address = null;
        $this->telephone = null;
        $this->ubigeo = null;
        $this->country_id = 'PE';
        $this->sex = null;
        $this->place_birth = null;
    }
}
