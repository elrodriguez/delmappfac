<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function list(){
        return datatables(Role::query())
            ->addColumn('edit_url', function($row){
                return route('role_edit', $row->id);
            })->addColumn('permission_url', function($row){
                return route('permission_roles', $row->id);
            })->addColumn('delete_url', function($row){
                return route('roles_delete', $row->id);
            })->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })->make(true);
    }
    public function destroy($id){
        $role = Role::find($id);
        $data = 'fail';
        if($role){
            $role = $role->delete();
        }
        return response()->json(['success'=>true,'name'=>''], 200);
    }
}
