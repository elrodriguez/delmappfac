<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function usersList(){
        return datatables(User::query())
            ->addColumn('edit_url', function($row){
                return route('user_edit', $row->id);
            })->addColumn('roles_url', function($row){
                return route('user_roles', $row->id);
            })->addColumn('delete_url', function($row){
                return route('users_delete', $row->id);
            })->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
    public function destroy($id){
        $user = User::find($id);
        $data = 'fail';
        if($user){
            $data = $user->delete();
        }
        return response()->json(['success'=>$data,'name'=>$user->name], 200);
    }

    public function usersListActivityLog(){
        return datatables(User::query())
            ->addColumn('details_url', function($row){
                return route('users_activity_log_details', $row->id);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }

}
