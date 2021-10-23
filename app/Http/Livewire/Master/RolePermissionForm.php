<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RolePermissionForm extends Component
{
    public $permissions;
    public $id_role;
    public $role_permissions = [];
    public $servicios;
    public $new_permission;

    protected $rules = [
        'new_permission' => 'required|min:3'
    ];

    public function mount($id_role)
    {
        $this->id_role = $id_role;
        $this->refreshSelect();
    }

    public function render()
    {
        $this->permissions = Permission::all();

        return view('livewire.master.role-permission-form');
    }
    public function refreshSelect(){
        $permi = Permission::all();
        $array = Permission::join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
        ->select('permissions.id')
        ->where('role_has_permissions.role_id',$this->id_role)
        ->get();

        $items = [];

        foreach($permi as $c => $row){
            $idper = false;
            foreach($array as $item){
                if($item->id == $row->id){
                    $idper = $row->id;
                }
            }
            $items[$c] = $idper;
        }
        $this->role_permissions = $items;

    }
    public function store(){

        $role = Role::find($this->id_role);
        $role->permissions()->detach();

        foreach($this->role_permissions as $row){
            if($row != false){
                $perm = DB::table('permissions')->where('id',$row)->select('permissions.name')->first();
                if($perm){
                    $role->givePermissionTo($perm->name);
                }
            }

        }

        $this->refreshSelect();
        $this->dispatchBrowserEvent('response_permissions_role_store', ['message' => 'Permisos actualizados correctamente.']);
    }
    public function newPermision(){

        $this->validate();

        $role = Role::find($this->id_role);
        $permission = Permission::create([
            'name' => $this->new_permission,
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo($permission->name);
        $this->refreshSelect();
    }
}
