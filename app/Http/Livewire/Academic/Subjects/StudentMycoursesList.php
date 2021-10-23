<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Enrollment\CadastreCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentMycoursesList extends Component
{
    public $courses;

    public function render()
    {
        $this->coursesList();
        return view('livewire.academic.subjects.student-mycourses-list');
    }
    public function coursesList(){
        $id = Auth::user()->person_id;
        $season = AcademicSeason::where('state',1)->first();

        $this->courses = CadastreCourse::join('cadastres','cadastre_courses.cadastre_id','cadastres.id')
                    ->join('academic_levels','cadastres.academic_level_id','academic_levels.id')
                    ->join('academic_sections','cadastres.academic_section_id','academic_sections.id')
                    ->join('academic_years','cadastres.academic_year_id','academic_years.id')
                    ->leftJoin('teacher_courses',function ($query){
                        $query->on('teacher_courses.academic_level_id','cadastres.academic_level_id')
                            ->on('teacher_courses.academic_year_id','cadastres.academic_year_id')
                            ->on('teacher_courses.academic_section_id','cadastres.academic_section_id')
                            ->on('teacher_courses.academic_season_id','cadastres.academic_season_id')
                            ->on('teacher_courses.course_id','cadastre_courses.course_id')
                            ->on('teacher_courses.curricula_id','cadastres.curricula_id')
                            ->where('teacher_courses.state',1);
                    })
                    ->join('teachers','teacher_courses.teacher_id','teachers.id')
                    ->join('courses','cadastre_courses.course_id','courses.id')
                    ->join('people','teachers.person_id','people.id')
                    ->select(
                        'teacher_courses.id AS teacher_course_id',
                        'courses.id AS course_id',
                        'cadastres.id AS cadastre_id',
                        'academic_levels.id AS level_id',
                        'academic_levels.description AS level_description',
                        'academic_sections.description AS section_description',
                        'academic_years.description AS year_description',
                        'courses.description',
                        'people.trade_name'
                    )
                    ->where('cadastres.person_id',$id)
                    ->where('cadastres.academic_season_id',$season->id)
                    ->whereNull('cadastres.deleted_at')
                    ->orderBy('academic_levels.id')
                    ->get();

                    //dd($this->courses);
    }
}
