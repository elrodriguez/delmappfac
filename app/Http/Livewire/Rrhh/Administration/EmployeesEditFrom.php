<?php

namespace App\Http\Livewire\Rrhh\Administration;

use App\Http\Controllers\Master\UbigeoController;
use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Person;
use App\Models\RRHH\Administration\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EmployeesEditFrom extends Component
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
    public $family_burden;

    public function mount($person_id){
        $this->person_id = $person_id;
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
        $person = Person::find($person_id);
        $emploee = Employee::where('person_id',$person_id)->first();
        $this->identity_document_type_id = $person->identity_document_type_id;
        $this->number = $person->number;
        $this->birth_date = Carbon::parse($person->birth_date)->format('d/m/Y');
        $this->marital_state = $person->marital_state;
        $this->name = $person->name;
        $this->last_paternal = $person->last_paternal;
        $this->last_maternal = $person->last_maternal;
        $this->email = $person->email;
        $this->trade_name = $person->trade_name;
        $this->address = $person->address;
        $this->telephone = $person->telephone;
        $this->ubigeo = $person->ubigeo;
        $this->country_id = $person->country_id;
        $this->sex = $person->sex;
        $this->place_birth = $person->place_birth;
        $this->ubigeo = $person->department_id.'*'.$person->province_id.'*'.$person->district_id;
        $this->family_burden = $emploee->family_burden;
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();

        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.rrhh.administration.employees-edit-from');
    }

    public function update(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric',
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

        Employee::where('person_id',$this->person_id)->update([
            'family_burden' => $this->family_burden
        ]);

        $this->dispatchBrowserEvent('response_employees_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

}
