<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Establishment;
use App\Models\Master\Person;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Team;
use Illuminate\Support\Facades\Lang;

class UserCreateForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $establishments;
    public $establishment_id;
    public $number;
    public $person = [];
    public $person_id = null;
    public $error_num = null;
    public $disabled = true;

    public function render()
    {
        $this->establishments = Establishment::where('state',1)->get();
        return view('livewire.master.user-create-form');
    }
    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'password' => 'required|min:8',
            'email' => 'required|email:rfc,dns|unique:users',
            'establishment_id' => 'required'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'person_id' => $this->person_id,
            'establishment_id' => $this->establishment_id
        ]);

        $user->assignRole('Public');

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Equipo",
            'personal_team' => true,
        ]));

        $this->resetInput();
        $this->dispatchBrowserEvent('response_success_user', ['message' => Lang::get('messages.successfully_registered')]);
    }
    private function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->establishment_id = null;
        $this->number = null;
    }

    public function searchPersonDataBase(){

        $this->validate([
            'number' => 'required'
        ]);

        $this->person = Person::where('number',$this->number)->first();

        if($this->person){
            $this->person_id = $this->person->id;
            $user = User::where('person_id',$this->person_id)->first();
            if(!$user){
                $this->name = $this->person->name;
                $this->email = $this->person->email;
                $this->error_num = null;
                $this->disabled = false;
            }else{
                $this->disabled = true;
                $this->dispatchBrowserEvent('response_search_message_person', ['message' => 'Ya cuenta con usuario']);
            }
        }else{
            $this->disabled = true;
            $this->dispatchBrowserEvent('response_search_message_person', ['message' => 'No existen resultados']);
        }

    }
}
