<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Enrollment\Cadastre;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentMycoursesListCourses extends Component
{
    public $courses;

    public function render()
    {
        $this->coursesList();
        return view('livewire.academic.subjects.student-mycourses-list-courses');
    }

    public function coursesList(){
        $id = Auth::user()->person_id;

        $this->courses = Cadastre::join('academic_levels','cadastres.academic_level_id','academic_levels.id')
                    ->join('academic_years','cadastres.academic_year_id','academic_years.id')
                    ->join('courses','cadastres.course_id','courses.id')
                    ->leftJoin('teacher_courses',function ($query){
                        $query->on('teacher_courses.academic_level_id','cadastres.academic_level_id')
                            ->on('teacher_courses.academic_year_id','cadastres.academic_year_id')
                            ->on('teacher_courses.course_id','cadastres.course_id')
                            ->where('teacher_courses.state',1);
                    })
                    ->leftJoin('teachers','teacher_courses.teacher_id','teachers.id')
                    ->leftJoin('people','teachers.person_id','people.id')
                    ->select(
                        'teacher_courses.id AS teacher_course_id',
                        'courses.id AS course_id',
                        'cadastres.id AS cadastre_id',
                        'academic_levels.id AS level_id',
                        'academic_levels.description AS level_description',
                        'academic_years.description AS year_description',
                        'courses.description',
                        'people.trade_name'
                    )
                    ->where('cadastres.person_id',$id)
                    ->whereNull('cadastres.deleted_at')
                    ->orderBy('academic_levels.id')
                    ->get();

    }
}
