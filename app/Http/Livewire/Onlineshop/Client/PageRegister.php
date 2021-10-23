<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Master\Customer;
use App\Models\Master\Department;
use App\Models\Master\District;
use App\Models\Master\Person;
use App\Models\Master\PersonTypeDetail;
use App\Models\Master\Province;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PageRegister extends Component
{
    public $documet_types;
    public $regions;
    public $provinces = [];
    public $districts = [];
    public $region_id;
    public $province_id;
    public $district_id;
    public $documet_type_id;
    public $number;
    public $address;
    public $names;
    public $last_name_p;
    public $last_name_m;
    public $email;
    public $password;
    public $date_of_birth;
    public $gender;


    public function mount(){
        $this->documet_types = IdentityDocumentType::where('active',true)->get();
        $this->regions = Department::where('active',true)->get();
       
        
    }
    public function render()
    {
        return view('livewire.onlineshop.client.page-register');
    }
    public function searchProvince(){
        $this->provinces = Province::where('active',true)
            ->where('department_id',$this->region_id)
            ->get();
    }
    public function searchDistrict(){
        $this->districts = District::where('active',true)
            ->where('province_id',$this->province_id)
            ->get();;
    }

    protected $rules = [
        'documet_type_id' => 'required',
        'number' => 'numeric|required|unique:people',
        'address' => 'required|max:255',
        'region_id' => 'required',
        'province_id' => 'required',
        'district_id' => 'required',
        'names' => 'required|max:255',
        'last_name_p' => 'required|max:255|alpha',
        'last_name_m' => 'required|max:255|alpha',
        'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        'password' => 'required',
        'date_of_birth' => 'required',
        'gender' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveClient(){

        $this->validate();

        $person = Person::create([
            'type' => 'customers',
            'identity_document_type_id' => $this->documet_type_id,
            'number' => $this->number,
            'name' => $this->names,
            'trade_name' => $this->last_name_p.' '.$this->last_name_m.' '.$this->names,
            'country_id' => 'PE',
            'department_id' => $this->region_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'address' => $this->address,
            'email' => $this->email,
            'last_paternal' => $this->last_name_p,
            'last_maternal' => $this->last_name_m,
            'sex' => $this->gender,
            'marital_state' => 'soltero',
            'birth_date' => $this->date_of_birth
        ]);
        
        Customer::create([
            'person_id' => $person->id
        ]);
        PersonTypeDetail::create([
            'person_id' => $person->id,
            'person_type_id' => 1
        ]);

        $password = Hash::make($this->password);

        $user = User::create([
            'name' => $this->names.' '.$this->last_name_p,
            'email' => $this->email,
            'password' => $password,
            'person_id' => $person->id,
            'lang' => 'es'
        ]);

        $user->assignRole('Cliente');

        // $user->ownedTeams()->save(Team::forceCreate([
        //     'user_id' => $user->id,
        //     'name' => explode(' ', $user->name, 2)[0]."'s Equipo",
        //     'personal_team' => true,
        // ]));

        Auth::login($user);
        
        return redirect()->route('onlineshop_public_home');
    }
}
