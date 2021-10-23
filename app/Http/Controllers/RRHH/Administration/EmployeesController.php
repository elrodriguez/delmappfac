<?php

namespace App\Http\Controllers\RRHH\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Master\PersonTypeDetail;
use App\Imports\EmployeesImport;
use App\Models\Master\Person;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function list(){
        return datatables($this->customersjoin())
            ->addColumn('edit_url', function($row){
                return route('rrhh_administration_employees_edit', $row->id);
            })
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->birth_date)->format('d/m/Y');
            })
            ->make(true);
    }
    public function customersjoin(){
        return PersonTypeDetail::query()->select('people.*')
            ->join('people','person_type_details.person_id','people.id')
            ->where('person_type_details.person_type_id',3)
            ->whereNull('people.deleted_at');
    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $import = new EmployeesImport();
            //Excel::import($import, request()->file('alumnos'));
            if(Excel::import($import, $file)) {
                return response()->json('success', 200);
            } else {
                return response()->json('error', 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 400);
        }

    }
    // public function searchEmployee(){
    //     return datatables()->eloquent($this->personQuery())->filter(function ($query) {
    //             if (request()->has('responsable')) {
    //                 $query->where('name', 'like', "%" . request('responsable') . "%")
    //                 ->where('type','customers');
    //             }
    //         })
    //         ->toJson();
    // }
    public function searchEmployee(){
        return Person::join('employees','people.id','employees.person_id')
            ->select('people.*')
            ->where(DB::raw("REPLACE(people.name, ' ', '')"), 'LIKE', '%' . str_replace(' ','',request('responsable')). '%')
            ->paginate(50);
    }
}
