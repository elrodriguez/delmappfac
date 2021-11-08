<?php

namespace App\Http\Livewire\Logistics\Catalogs;

use App\Http\Controllers\Master\UbigeoController;
use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use App\Models\Master\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ProvidersEditForm extends Component
{
    public $person_id;
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
    public $time_arrival="";

    public function mount($provider_id){
        $this->person_id = $provider_id;
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
        $provider = Person::find($provider_id);

        $this->identity_document_type_id = $provider->identity_document_type_id;
        $this->number = $provider->number;
        $this->name = $provider->name;
        $this->last_paternal = $provider->last_paternal;
        $this->last_maternal = $provider->last_maternal;
        $this->email = $provider->email;
        $this->trade_name = $provider->trade_name;
        $this->address = $provider->address;
        $this->telephone = $provider->telephone;
        $this->ubigeo = $provider->ubigeo;
        $this->country_id = $provider->country_id;
        $this->time_arrival = Supplier::where('person_id',$this->person_id)->value('time_arrival');
        $this->ubigeo = $provider->department_id.'*'.$provider->province_id.'*'.$provider->district_id;
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();

        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();

        return view('livewire.logistics.catalogs.providers-edit-form');
    }

    public function update(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric|unique:people,number,'.$this->person_id,
            'name' => 'required|min:3',
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'time_arrival' => 'required'
        ]);

        /*list($d,$m,$y) = explode('/',$this->birth_date);
        $birth_date = $y.'-'.$m.'-'.$d;*/
        list($dp,$pv,$ds) = explode('*',$this->ubigeo);

        $provider = Person::where('id',$this->person_id)->update([
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

        $supplier = supplier::where('person_id',$this->person_id)->update([
            'time_arrival' => $this->time_arrival
            ]);

        $this->dispatchBrowserEvent('response_providers_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

}
