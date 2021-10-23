<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicCharge;
use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Administration\AcademicSection;
use App\Models\Academic\Administration\AcademicYear;
use App\Models\Academic\Administration\Course;
use App\Models\Academic\Administration\Curricula;
use App\Models\Academic\Administration\TeacherCourse;
use App\Models\Master\Parameter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TeacherAssignCoursesFreeForm extends Component
{
    public $PRT0001GN;
    public $levels;
    public $years = [];
    public $courses = [];
    public $assignments;
    public $level_id;
    public $year_id;
    public $course_id;
    public $teacher_id;

    public function mount($teacher_id){
        $this->teacher_id = $teacher_id;
        $this->levels = AcademicLevel::all();
        $this->PRT0001GN = Parameter::where('id_parameter','PRT0001GN')->first();
    }

    public function loadYear(){
        $this->years = AcademicYear::where('academic_level_id',$this->level_id)->get();
    }

    public function render()
    {
        $this->listAssignments();
        $this->listCourses();
        return view('livewire.academic.administration.teacher-assign-courses-free-form');
    }

    public function store(){
        $this->validate([
            'level_id'=>'required',
            'year_id'=>'required',
            'course_id'=> ['required', Rule::unique('teacher_courses','course_id')->where(function ($query) {
                $query->where('teacher_id', $this->teacher_id)
                ->where('academic_year_id', $this->year_id)
                ->where('academic_level_id', $this->level_id)
                ->whereNull('teacher_courses.deleted_at');
            }) ]
        ]);


        $exists = TeacherCourse::where('academic_level_id',$this->level_id)
            ->where('academic_year_id',$this->year_id)
            ->where('course_id',$this->course_id)
            ->exists();

        if($exists){
            TeacherCourse::where('academic_level_id',$this->level_id)
            ->where('academic_year_id',$this->year_id)
            ->where('course_id',$this->course_id)
            ->update(['state'=>0]);
        }

        TeacherCourse::create([
            'academic_level_id' => $this->level_id,
            'academic_year_id' => $this->year_id,
            'teacher_id' => $this->teacher_id,
            'course_id' => $this->course_id
        ]);

        $this->listAssignments();
        $this->clearForm();
    }
    public function clearForm(){
        $this->level_id = null;
        $this->year_id = null;
        $this->course_id = null;
    }

    public function listAssignments(){
        $this->assignments = TeacherCourse::join('academic_levels','teacher_courses.academic_level_id','academic_levels.id')
            ->join('academic_years','teacher_courses.academic_year_id','academic_years.id')
            ->join('courses','teacher_courses.course_id','courses.id')
            ->select(
                'teacher_courses.id',
                'academic_levels.description AS academic_level_description',
                'academic_years.description AS academic_year_description',
                'courses.description AS course_description',
                'teacher_courses.created_at'
            )
            ->where('teacher_courses.teacher_id',$this->teacher_id)
            ->get();
    }

    public function removeAssignment($id){
        TeacherCourse::where('id',$id)->delete();
        $this->listAssignments();
    }

    public function listCourses(){
        $this->courses = Course::where('academic_level_id',$this->level_id)
            ->where('academic_year_id',$this->year_id)
            ->get();
    }
}
