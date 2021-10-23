<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\Teacher;
use App\Models\Master\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TeachersController extends Controller
{
    public function list(){
        return datatables($this->coursesJoin())
            ->addColumn('edit_url', function($row){
                return route('academic_teachers_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('academic_teachers_delete', $row->id);
            })
            ->addColumn('assign_courses_url', function($row){
                return route('academic_teachers_courses', $row->teacher_id);
            })
            ->addColumn('assign_courses_free_url', function($row){
                return route('academic_teachers_courses_free', $row->teacher_id);
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
        return Teacher::query()->join('people','teachers.person_id','people.id')
        ->select([
            'teachers.id AS teacher_id',
            'people.id',
            'people.number',
            'people.trade_name',
            'people.address',
            'people.email',
            'people.telephone',
            'people.sex',
            'people.birth_date',
            'teachers.created_at'
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
}
