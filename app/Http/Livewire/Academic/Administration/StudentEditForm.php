<?php

namespace App\Http\Livewire\Academic\Administration;

use Livewire\Component;
use App\Models\catalogue\IdentityDocumentType;
use App\Http\Controllers\Master\UbigeoController;
use App\Models\Academic\Administration\Student;
use App\Models\Master\Person;
use Illuminate\Support\Facades\Lang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Team;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StudentEditForm extends Component
{
    public $student_id;
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
    public $user_student;

    public function mount($student_id){
        $this->student_id = $student_id;
        $student = Person::find($this->student_id);
        $this->user_student = User::where('person_id',$this->student_id)->first();

        $this->identity_document_type_id = $student->identity_document_type_id;
        $this->number = $student->number;
        $this->birth_date = Carbon::parse($student->birth_date)->format('d/m/Y');
        $this->marital_state = $student->marital_state;
        $this->name = $student->name;
        $this->last_paternal = $student->last_paternal;
        $this->last_maternal = $student->last_maternal;
        $this->email = $student->email;
        $this->trade_name = $student->trade_name;
        $this->address = $student->address;
        $this->telephone = $student->telephone;
        $this->ubigeo = $student->department_id.'*'.$student->province_id.'*'.$student->district_id;
        $this->country_id = $student->country_id;
        $this->sex = $student->sex;
        $this->place_birth = $student->place_birth;

        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.academic.administration.student-edit-form');
    }
    public function update(){
        $user_validate = User::where('person_id',$this->student_id)->first();

        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric',
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.($user_validate?$user_validate->id:null),
            'country_id' => 'required',
            'last_paternal' => 'required|min:2',
            'last_maternal' => 'required|min:2',
            'sex' => 'required',
            'birth_date' => 'required',
        ]);

        list($d,$m,$y) = explode('/',$this->birth_date);
        $birth_date = $y.'-'.$m.'-'.$d;
        list($dp,$pv,$ds) = explode('*',$this->ubigeo);

        Person::where('id',$this->student_id)->update([
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

        if($this->user_create == 1){

            $user = User::where('person_id',$this->person_id)->first();

            if(!$user){
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->number),
                    'person_id' => $this->student_id
                ]);

                $user->assignRole('Alumno');
                $user->assignRole('Public');

                $user->ownedTeams()->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $this->name, 2)[0]."'s Equipo",
                    'personal_team' => true,
                ]));
            }
            $this->user_student = User::where('person_id',$this->student_id)->first();
        }

        Student::where('id_person',$this->student_id)->update([
            'country_id' => $this->country_id,
            'department_id' => $dp,
            'province_id' => $pv,
            'district_id' => $ds,
            'number_dni' => $this->number
        ]);

        $this->dispatchBrowserEvent('response_students_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
