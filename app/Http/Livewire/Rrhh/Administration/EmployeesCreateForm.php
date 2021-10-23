<?php

namespace App\Http\Livewire\Rrhh\Administration;

use App\Http\Controllers\Master\UbigeoController;
use App\Http\Controllers\Master\PersonController;
use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use App\Models\RRHH\Administration\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EmployeesCreateForm extends Component
{
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
    public $family_burden = 'NO';
    public $person_id;
    public $error_num = null;

    public function mount(){
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();

        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();

        return view('livewire.rrhh.administration.employees-create-form');
    }

    public function store(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric',
            'name' => 'required|min:3',
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'sex' => 'required',
            'birth_date' => 'required',
            'ubigeo' => 'required'
        ]);

        if($this->person_id == null){
            $this->validate([
                'number' => 'unique:people,number,NULL,id,identity_document_type_id,' . $this->identity_document_type_id,
            ]);
        }

        if($this->person_id == null){
            list($d,$m,$y) = explode('/',$this->birth_date);
            $birth_date = $y.'-'.$m.'-'.$d;
            list($dp,$pv,$ds) = explode('*',$this->ubigeo);

            $people = Person::create([
                'type' => 'customers',
                'identity_document_type_id' => $this->identity_document_type_id,
                'number' => $this->number,
                'name' => $this->name,
                'trade_name' => $this->name.' '.$this->last_paternal.' '.$this->last_maternal,
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

            $this->person_id = $people->id;
        }
        PersonTypeDetail::create([
            'person_id' => $this->person_id,
            'person_type_id' => 3
        ]);

        Employee::create([
            'person_id' => $this->person_id,
            'family_burden' => $this->family_burden,
            'state' => 1
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('response_employees_store', ['message' => Lang::get('messages.successfully_registered')]);
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
        $this->person_id = null;
    }

    public function onSearch($search){
        if($search == '1'){
            $this->searchPersonDataBase();
        }elseif($search == '3'){
            $this->searchPersonReniec();
        }
    }

    private function searchPersonDataBase(){

        $this->validate([
            'number' => 'required',
            'identity_document_type_id' => 'required'
        ]);

        $this->person = Person::where('number',$this->number)->where('identity_document_type_id',$this->identity_document_type_id)->first();
        if($this->person){
            $this->person_id = $this->person->id;
            $this->identity_document_type_id = $this->person->identity_document_type_id;
            $this->number = $this->person->number;
            $this->birth_date = Carbon::parse($this->person->birth_date)->format('d/m/Y');
            $this->marital_state = $this->person->marital_state;
            $this->name = $this->person->name;
            $this->last_paternal = $this->person->last_paternal;
            $this->last_maternal = $this->person->last_maternal;
            $this->email = $this->person->email;
            $this->trade_name = $this->person->trade_name;
            $this->address = $this->person->address;
            $this->telephone = $this->person->telephone;
            //$this->ubigeo = $this->person->department_id.'*'.$this->person->province_id.'*'.$this->person->district_id;
            $this->country_id = $this->person->country_id;
            $this->sex = $this->person->sex;
            $this->place_birth = $this->person->place_birth;
            $this->error_num = null;
        }else{
            $this->dispatchBrowserEvent('response_search_message_person', ['message' => 'No existen resultados']);
        }

    }

    private function searchPersonReniec(){
        $person = new PersonController;
        $data = (array) $person->getDataDni($this->number);
        //dd($data);
        if($data){
            if (array_key_exists('tipoDocumento', $data)){
                $this->identity_document_type_id = $data['tipoDocumento'];
                $this->number = $data['numeroDocumento'];
                $this->trade_name = $data['nombre'];
                $this->name = $data['nombres'];
                $this->last_paternal = $data['apellidoPaterno'];
                $this->last_maternal = $data['apellidoMaterno'];
                $this->person_id = null;
                $this->error_num = null;
            }elseif(array_key_exists('error', $data)){
                $this->error_num = $data['error'];
            }
        }else{
            $this->dispatchBrowserEvent('response_search_message_person', ['message' => 'No existen resultados']);
        }

    }

}
