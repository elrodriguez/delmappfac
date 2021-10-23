<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Establishment;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class UserEditForm extends Component
{
    public $id_user;
    public $name;
    public $email;
    public $password;
    public $establishments;
    public $establishment_id;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = null;
        $this->id_user = $user->id;
        $this->establishment_id = $user->establishment_id;
    }
    public function render()
    {
        $this->establishments = Establishment::where('state',1)->get();
        return view('livewire.master.user-edit-form');
    }
    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$this->id_user,
            'establishment_id' => 'required'
        ]);
        $user = User::find($this->id_user);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => ($this->password != null ? Hash::make($this->password):$user->password),
            'establishment_id' => $this->establishment_id
        ]);

        $this->dispatchBrowserEvent('response_success_user', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
