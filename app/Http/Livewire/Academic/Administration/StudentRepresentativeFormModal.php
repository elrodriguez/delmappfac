<?php

namespace App\Http\Livewire\Academic\Administration;

use Livewire\Component;
use App\Models\catalogue\IdentityDocumentType;
use App\Http\Controllers\Master\UbigeoController;
use App\Models\Academic\Administration\StudentRepresentative;
use App\Models\Master\Person;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentRepresentativeFormModal extends Component
{
    public $student_id;
    public $person_id;
    public $identity_document_type_id = 1;
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
    public $user_create = 0;
    public $sex;
    public $place_birth;
    public $identity_document_types = [];
    public $countries = [];
    public $ubigeos = [];
    public $representatives = [];
    public $representative_id;

    public function mount($person_id,$student_id){
        $this->person_id = $person_id;
        $this->student_id = $student_id;
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
        $this->listRepresentative();
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.academic.administration.student-representative-form-modal');
    }
    public function store(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric|unique:people,number,null,id,identity_document_type_id,' . $this->identity_document_type_id,
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'sex' => 'required',
            'birth_date' => 'required',
        ]);

        list($d,$m,$y) = explode('/',$this->birth_date);
        $birth_date = $y.'-'.$m.'-'.$d;
        list($dp,$pv,$ds) = explode('*',$this->ubigeo);

        $representative = Person::create([
            'type' => 'customers',
            'identity_document_type_id' => $this->identity_document_type_id,
            'number' => $this->number,
            'name' => $this->name,
            'trade_name' => ($this->name.' '.$this->last_paternal.' '.$this->last_maternal),
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

        StudentRepresentative::create([
            'representative_id' => $representative->id,
            'student_id' => $this->student_id,
            'person_student_id' => $this->person_id
        ]);
        $this->listRepresentative();
        $this->resetInput();
        $this->dispatchBrowserEvent('response_student_store', ['message' => Lang::get('messages.successfully_registered')]);
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

    public function listRepresentative(){
        $representatives = StudentRepresentative::join('people','student_representatives.representative_id','people.id')
            ->select(
                'student_representatives.id',
                'people.number',
                'people.trade_name',
                'people.address',
                'people.telephone',
                'people.birth_date',
                DB::raw('TIMESTAMPDIFF(YEAR,people.birth_date,CURDATE()) AS age'),
                'student_representatives.lives',
                'student_representatives.live_with_the_student',
                'student_representatives.relationship',
                'student_representatives.state'
            )
            ->where('student_id',$this->student_id)
            ->get();
        foreach($representatives as $key => $representative){
            $this->representatives[$key] = [
                'id' => $representative->id,
                'number' => $representative->number,
                'trade_name' => $representative->trade_name,
                'address' => $representative->address,
                'telephone' => $representative->telephone,
                'birth_date' => $representative->birth_date,
                'age' => $representative->age,
                'relationship' => $representative->relationship,
                'lives' => $representative->lives,
                'live_with_the_student' => $representative->live_with_the_student,
                'state' => $representative->state
            ];
        }
    }

    public function updateRepresentation($index){
        $this->validate([
            'representatives.'.$index.'.relationship' => 'required'
        ]);
        $representative = $this->representatives[$index];
        StudentRepresentative::where('id',$representative['id'])
            ->update([
                'lives' => $representative['lives'],
                'live_with_the_student' => $representative['live_with_the_student'],
                'relationship' => $representative['relationship'],
                'state' => $representative['state']
            ]);
        $this->dispatchBrowserEvent('response_student_representation_update', ['message' => Lang::get('messages.was_successfully_updated')]);
        $this->listRepresentative();
    }

    public function addRepresentation(){
        $this->validate([
            'representative_id'=> ['required', Rule::unique('student_representatives','representative_id')->where(function ($query) {
                $query->where('student_id', $this->student_id)
                ->whereNull('deleted_at');
            }) ]
        ]);
        StudentRepresentative::create([
            'representative_id' => $this->representative_id,
            'student_id' => $this->student_id,
            'person_student_id' => $this->person_id
        ]);
        $this->dispatchBrowserEvent('response_student_representation_add', ['message' => Lang::get('messages.successfully_registered')]);
        $this->listRepresentative();
    }
}
