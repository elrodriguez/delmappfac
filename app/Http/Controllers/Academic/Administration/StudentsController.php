<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Academic\Administration\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Master\Person;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    public function list(){
        return datatables($this->coursesJoin())
            ->addColumn('edit_url', function($row){
                return route('academic_students_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('academic_students_delete', $row->id);
            })
            ->addColumn('representative_url', function($row){
                return route('academic_students_representative', [$row->id,$row->student_id]);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('birth_date', function($row){
                return Carbon::parse($row->birth_date)->format('d/m/Y');
            })
            ->make(true);
    }
    public function coursesJoin(){
        return Student::query()->join('people','students.id_person','people.id')
        ->select([
            'students.id AS student_id',
            'people.id',
            'people.number',
            'people.trade_name',
            'people.address',
            'people.email',
            'people.telephone',
            'people.sex',
            'people.birth_date',
            'students.created_at'
        ])
        ->whereNull('people.deleted_at');
    }
    public function destroy($id){
        $teacher = Person::find($id);
        if($teacher){
            $teacher->delete();
        }
        return response()->json(['success'=>true,'name'=>$teacher->name], 200);
    }

    public function searchPeople(){
        return datatables()->eloquent(Person::query())->filter(function ($query) {
                    if (request()->has('person')) {
                        $query->where('trade_name', 'like', "%" . request('person') . "%")
                        ->orWhere('number', 'like', "%" . request('person') . "%");
                    }
                })
                ->toJson();

    }

    public function import(Request $request)
    {
        try {
            $file = $request->file('file');
            $import = new StudentsImport();
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
}
