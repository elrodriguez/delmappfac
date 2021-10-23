<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Administration\TeacherCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CoursesTeacherList extends Component
{
    public $courses;

    public function render()
    {
        $this->teacherCoursesList();
        return view('livewire.academic.subjects.courses-teacher-list');
    }

    public function teacherCoursesList(){
        $id = Auth::user()->person_id;
        $season = AcademicSeason::where('state',1)->first();

        $this->courses = TeacherCourse::join('courses','teacher_courses.course_id','courses.id')
                    ->join('academic_levels','teacher_courses.academic_level_id','academic_levels.id')
                    ->join('academic_sections','teacher_courses.academic_section_id','academic_sections.id')
                    ->join('academic_years','teacher_courses.academic_year_id','academic_years.id')
                    ->join('teachers','teacher_courses.teacher_id','teachers.id')
                    ->select(
                        'teacher_courses.id AS teacher_course_id',
                        'courses.id',
                        'academic_levels.id AS level_id',
                        'academic_levels.description AS level_description',
                        'academic_sections.description AS section_description',
                        'academic_years.description AS year_description',
                        'courses.description'
                    )
                    ->where('teachers.person_id',$id)
                    ->where('teacher_courses.academic_season_id',$season->id)
                    ->orderBy('academic_levels.id')
                    ->get();
    }
}
