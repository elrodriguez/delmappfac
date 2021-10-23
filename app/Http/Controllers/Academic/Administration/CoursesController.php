<?php

namespace App\Http\Controllers\Academic\Administration;

use App\Http\Controllers\Controller;
use App\Models\Academic\Administration\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CoursesController extends Controller
{
    public function list(){
        return datatables($this->coursesJoin())
            ->addColumn('edit_url', function($row){
                return route('academic_courses_edit', $row->id);
            })
            ->addColumn('delete_url', function($row){
                return route('academic_courses_delete', $row->id);
            })
            ->addColumn('academic_charges_url', function($row){
                return route('academic_courses_academic_charges', $row->id);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->make(true);
    }
    public function coursesJoin(){
        return Course::query()->leftJoin('academic_levels','courses.academic_level_id','academic_levels.id')
        ->leftJoin('academic_years','courses.academic_year_id','academic_years.id')
        ->leftJoin('academic_sections','courses.academic_section_id','academic_sections.id')
        ->select([
            'courses.id',
            'academic_levels.description AS academic_level_description',
            'courses.academic_level_id',
            'courses.academic_year_id',
            'academic_years.description AS academic_year_description',
            'academic_sections.description AS academic_section_description',
            'courses.description AS course_description',
            'courses.created_at',
            'courses.state'
        ]);
    }
    public function destroy($id){
        $course = Course::find($id);
        if($course){
            $course->delete();
        }
        return response()->json(['success'=>true,'name'=>$course->name], 200);
    }
}
