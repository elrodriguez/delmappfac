<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PackagesController extends Controller
{
    public function list(){
        return datatables(Package::query())
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->addColumn('edit_url', function($row){
                return route('academic_packages_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('academic_packages_delete', $row->id);
            })
            ->addColumn('add_items_url', function($row){
                return route('academic_add_items_edit', $row->id);
            })
            ->make(true);
    }
    public function destroy($id){
        $package = Package::find($id);
        if($package){
            $package->delete();
        }
        return response()->json(['success'=>true,'name'=>$package->description], 200);
    }
}
