<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRole extends Component
{
    public $id_user;
    public $roles;
    public $roles_user = [];

    public function mount($id_user)
    {
        $this->refreshSelect($id_user);
    }
    public function render()
    {
        $this->roles = DB::table('roles')->select('roles.id', 'roles.name')->get();
        
        return view('livewire.master.user-role',['roles_array'=>$this->roles]);
    }

    public function store($id_user){
        $user = User::find($id_user);
        $user->roles()->detach();
        foreach($this->roles_user as $key => $rol){
            $rol = DB::table('roles')->where('id',$rol)->select('roles.name')->first();
            $user->assignRole($rol->name);
        }
        $this->refreshSelect($id_user);
        session()->flash('message', 'Roles del usuario actualizado correctamente.');
    }
    public function refreshSelect($id_user){
        $this->id_user = $id_user;
        $this->roles_user = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
       ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
       ->where('users.id',$this->id_user)
       ->pluck('roles.id');
    }
}
