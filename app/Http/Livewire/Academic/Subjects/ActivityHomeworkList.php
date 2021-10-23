<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\Course;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Subjects\ClassActivity;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActivityHomeworkList extends Component
{
    public $course;
    public $topic;
    public $activity_id;
    public $activity;
    public $students;

    public function mount($course,$topic,$activity){
        $this->course = $course;
        $this->activity_id = $activity;
        $this->topic = $topic;

    }

    public function render()
    {
        $this->studentList();
        return view('livewire.academic.subjects.activity-homework-list');
    }

    public function studentList(){

        $this->students = [];

        $course = Course::find($this->course);

        $level = $course->academic_level_id;
        $year = $course->academic_year_id;

        if($level && $year){
            $this->students = Cadastre::join('people','cadastres.person_id','people.id')
            ->leftJoin('class_activity_homework',function ($join) {
                $join->on('cadastres.course_id','class_activity_homework.course_id')
                    ->on('people.id','class_activity_homework.person_id')
                    ->whereNull('class_activity_homework.class_activity_homework_id');
            })
            ->leftJoin('users','people.id','users.person_id')
            ->select(
                'people.id AS person_id',
                'people.trade_name',
                'cadastres.course_id',
                'users.id AS user_id',
                'users.name AS user_name',
                'users.profile_photo_path AS avatar',
                'class_activity_homework.description',
                DB::raw('(SELECT MAX(created_at) FROM class_activity_homework AS t2 WHERE t2.class_activity_homework_id=class_activity_homework.id) AS created_at'),
                DB::raw('(SELECT CONCAT("[",GROUP_CONCAT(JSON_OBJECT("url",t2.description,"name",t2.file_name)),"]") FROM class_activity_homework AS t2 WHERE t2.class_activity_homework_id=class_activity_homework.id) AS files'),
                'class_activity_homework.points',
                'class_activity_homework.id',
                'class_activity_homework.state'
            )
            ->where('cadastres.course_id',$this->course)
            ->get();

            
        }else{
            $this->students = Cadastre::join('academic_charges', function ($join) {
                $join->on('cadastres.academic_level_id', 'academic_charges.academic_level_id')
                    ->on('cadastres.academic_section_id', 'academic_charges.academic_section_id')
                    ->on('cadastres.academic_year_id', 'academic_charges.academic_year_id')
                    ->on('cadastres.academic_season_id', 'academic_charges.academic_season_id')
                    ->on('cadastres.curricula_id', 'academic_charges.curricula_id');
            })
            ->join('people','cadastres.person_id','people.id')
            ->leftJoin('class_activity_homework',function ($join) {
                $join->on('academic_charges.course_id','class_activity_homework.course_id')
                    ->on('people.id','class_activity_homework.person_id')
                    ->whereNull('class_activity_homework.class_activity_homework_id');
            })
            ->leftJoin('users','people.id','users.person_id')
            ->select(
                'people.id AS person_id',
                'people.trade_name',
                'academic_charges.course_id',
                'users.id AS user_id',
                'users.name AS user_name',
                'users.profile_photo_path AS avatar',
                'class_activity_homework.description',
                DB::raw('(SELECT MAX(created_at) FROM class_activity_homework AS t2 WHERE t2.class_activity_homework_id=class_activity_homework.id) AS created_at'),
                DB::raw('(SELECT CONCAT("[",GROUP_CONCAT(JSON_OBJECT("url",t2.description,"name",t2.file_name)),"]") FROM class_activity_homework AS t2 WHERE t2.class_activity_homework_id=class_activity_homework.id) AS files'),
                'class_activity_homework.points',
                'class_activity_homework.id',
                'class_activity_homework.state'
            )
            ->where('academic_charges.course_id',$this->course)
            ->get();
        }

    }
}
