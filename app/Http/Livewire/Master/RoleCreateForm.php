<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleCreateForm extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.master.role-create-form');
    }
    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|unique:roles'
        ]);
        Role::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);
        $this->resetInput();
        session()->flash('message', 'Rol registrado correctamente.');
    }
    private function resetInput()
    {
        $this->name = null;
    }
}
