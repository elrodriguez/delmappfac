<?php

namespace App\Http\Livewire\Academic\Administration;

use Livewire\Component;
use App\Models\catalogue\IdentityDocumentType;
use App\Http\Controllers\Master\UbigeoController;
use App\Models\Academic\Administration\Teacher;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Support\Facades\Lang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Team;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherEditForm extends Component
{
    public $teacher_id;
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
    public $user_teacher;

    public function mount($teacher_id){
        $this->teacher_id = $teacher_id;
        $teacher = Person::find($this->teacher_id);
        $this->user_teacher = Teacher::where('person_id',$this->teacher_id)->first();

        $this->identity_document_type_id = $teacher->identity_document_type_id;
        $this->number = $teacher->number;
        $this->birth_date = Carbon::parse($teacher->birth_date)->format('d/m/Y');
        $this->marital_state = $teacher->marital_state;
        $this->name = $teacher->name;
        $this->last_paternal = $teacher->last_paternal;
        $this->last_maternal = $teacher->last_maternal;
        $this->email = $teacher->email;
        $this->trade_name = $teacher->trade_name;
        $this->address = $teacher->address;
        $this->telephone = $teacher->telephone;
        $this->ubigeo = $teacher->department_id.'*'.$teacher->province_id.'*'.$teacher->district_id;
        $this->country_id = $teacher->country_id;
        $this->sex = $teacher->sex;
        $this->place_birth = $teacher->place_birth;

        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();
    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.academic.administration.teacher-edit-form');
    }

    public function update(){
        $user_validate = User::find($this->user_teacher->user_id);

        $this->validate([
            'identity_document_type_id' => 'required',
            'number' => 'required|numeric',
            'number' => 'unique:people,number,'.$this->teacher_id.',id,identity_document_type_id,' . $this->identity_document_type_id,
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

        $teacher= Person::where('id',$this->teacher_id)->update([
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
                    'person_id' => $this->teacher_id
                ]);

                $user->assignRole('Docente');
                $user->assignRole('Public');

                $user->ownedTeams()->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => explode(' ', $this->name, 2)[0]."'s Equipo",
                    'personal_team' => true,
                ]));
            }
            Teacher::where('person_id',$this->teacher_id)->update([
                'person_id' => $this->teacher_id,
                'user_id' => $user->id
            ]);
        }



        $this->dispatchBrowserEvent('response_teachers_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
