<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Administration\Curricula;
use App\Models\Academic\Administration\Teacher;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Subjects\CourseTopic;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CoursesStudentsList extends Component
{
    public $course_id;
    public $students;
    public $teacher_course_id;
    public $course_topics;
    public $teacher;
    public $course_topic_id;

    public function  mount($course_id,$teacher_course_id){
        $this->course_id = $course_id;
        $this->teacher_course_id = $teacher_course_id;
        $this->teacher = Teacher::where('person_id',Auth::user()->person_id)->first();
    }

    public function render()
    {
        $this->studentsList();
        $this->listTopics();
        return view('livewire.academic.subjects.courses-students-list');
    }

    public function studentsList(){
        $this->students = [];
        $teacher_id = $this->teacher->id;


        $this->students = Cadastre::join('academic_charges', function ($join) {
            $join->on('cadastres.academic_level_id', 'academic_charges.academic_level_id')
                ->on('cadastres.academic_section_id', 'academic_charges.academic_section_id')
                ->on('cadastres.academic_year_id', 'academic_charges.academic_year_id')
                ->on('cadastres.academic_season_id', 'academic_charges.academic_season_id')
                ->on('cadastres.curricula_id', 'academic_charges.curricula_id');
        })
        ->join('teacher_courses', function ($join) use($teacher_id) {
            $join->on('teacher_courses.academic_level_id', 'academic_charges.academic_level_id')
                ->on('teacher_courses.academic_section_id', 'academic_charges.academic_section_id')
                ->on('teacher_courses.academic_year_id', 'academic_charges.academic_year_id')
                ->on('teacher_courses.academic_season_id', 'academic_charges.academic_season_id')
                ->on('teacher_courses.curricula_id', 'academic_charges.curricula_id')
                ->on('teacher_courses.course_id', 'academic_charges.course_id')
                ->where('teacher_courses.teacher_id',$teacher_id);
        })
        ->join('people','cadastres.person_id','people.id')
        ->leftJoin('users','people.id','users.person_id')
        ->select(
            'people.id AS person_id',
            'people.trade_name',
            'academic_charges.course_id',
            'users.id AS user_id',
            'users.name AS user_name',
            'users.profile_photo_path'
        )
        ->where('academic_charges.course_id',$this->course_id)
        ->groupBy(
            'people.id',
            'people.trade_name',
            'academic_charges.course_id',
            'users.id',
            'users.name',
            'users.profile_photo_path'
        )
        ->get();
    }

    public function listTopics(){

        $season = AcademicSeason::where('state',1)->first();
        $curricula = Curricula::where('state',1)->first();

        $this->course_topics = CourseTopic::join('teacher_courses', function($join){
                $join->on('course_topics.teacher_course_id','teacher_courses.id')
                    ->on('course_topics.course_id','teacher_courses.course_id');
            })
            ->where('course_topics.course_id',$this->course_id)
            ->where('teacher_courses.teacher_id',$this->teacher->id)
            ->where('teacher_courses.academic_season_id',$season->id)
            ->where('teacher_courses.curricula_id',$curricula->id)
            ->select(
                'course_topics.id',
                'course_topics.title'
            )
            ->get();
    }
}
