<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleEditForm extends Component
{
    public $id_rol;
    public $name;
    public $state;

    public function mount($id)
    {
        $user = Role::findOrFail($id);
        $this->name = $user->name;
        $this->id_rol = $user->id;
    }

    public function render()
    {
        return view('livewire.master.role-edit-form');
    }

    public function update($id)
    {
        $this->validate([
            'name' => 'required|unique:roles,name,'.$id
        ]);
        $role= Role::find($id);
        $role->update([
            'name' => $this->name
        ]);
        session()->flash('message', 'Rol actualizado correctamente.');
    }
}
