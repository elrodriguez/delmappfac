<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Administration\TeacherCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CoursesTeacherListFree extends Component
{
    public $courses;

    public function render()
    {
        $this->teacherCoursesList();
        return view('livewire.academic.subjects.courses-teacher-list-free');
    }

    public function teacherCoursesList(){
        $id = Auth::user()->person_id;

        $this->courses = TeacherCourse::join('courses','teacher_courses.course_id','courses.id')
                    ->join('academic_levels','courses.academic_level_id','academic_levels.id')
                    ->join('academic_years','courses.academic_year_id','academic_years.id')
                    ->join('teachers','teacher_courses.teacher_id','teachers.id')
                    ->select(
                        'teacher_courses.id AS teacher_course_id',
                        'courses.id',
                        'academic_levels.id AS level_id',
                        'academic_levels.description AS level_description',
                        'academic_years.description AS year_description',
                        'courses.description'
                    )
                    ->where('teachers.person_id',$id)
                    ->orderBy('academic_levels.id')
                    ->get();
    }
}
