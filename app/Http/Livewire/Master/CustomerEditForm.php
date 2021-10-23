<?php

namespace App\Http\Livewire\Master;

use App\Http\Controllers\Master\UbigeoController;
use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CustomerEditForm extends Component
{
    public $person_id;
    public $identity_document_type_id;
    public $number;
    public $birth_date;
    public $marital_state;
    public $name;
    public $last_paternal;
    public $last_maternal;
    public $email;
    public $trade_name;
    public $address;
    public $telephone;
    public $ubigeo;
    public $country_id = 'PE';
    public $sex;
    public $place_birth;
    public $identity_document_types = [];
    public $countries = [];
    public $ubigeos = [];

    public function mount($customer_id){
        $this->person_id = $customer_id;
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
        $customer = Person::find($customer_id);

        $this->identity_document_type_id = $customer->identity_document_type_id;
        $this->number = $customer->number;
        $this->birth_date = Carbon::parse($customer->birth_date)->format('d/m/Y');
        $this->marital_state = $customer->marital_state;
        $this->name = $customer->name;
        $this->last_paternal = $customer->last_paternal;
        $this->last_maternal = $customer->last_maternal;
        $this->email = $customer->email;
        $this->trade_name = $customer->trade_name;
        $this->address = $customer->address;
        $this->telephone = $customer->telephone;
        $this->ubigeo = $customer->ubigeo;
        $this->country_id = $customer->country_id;
        $this->sex = $customer->sex;
        $this->place_birth = $customer->place_birth;
        $this->ubigeo = $customer->department_id.'*'.$customer->province_id.'*'.$customer->district_id;
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();

        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();

        return view('livewire.master.customer-edit-form');
    }

    public function update(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric',
            'number' => 'unique:people,number,'.$this->person_id.',id,identity_document_type_id,' . $this->identity_document_type_id,
            'name' => 'required|min:3',
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'sex' => 'required',
            'birth_date' => 'required',
        ]);

        list($d,$m,$y) = explode('/',$this->birth_date);
        $birth_date = $y.'-'.$m.'-'.$d;
        list($dp,$pv,$ds) = explode('*',$this->ubigeo);

        Person::where('id',$this->person_id)->update([
            'type' => 'customers',
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
            'birth_date' => $birth_date,
            'place_birth' => $this->place_birth
        ]);

        $this->dispatchBrowserEvent('response_customers_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
