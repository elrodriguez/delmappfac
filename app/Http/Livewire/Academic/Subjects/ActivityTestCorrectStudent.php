<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\Student;
use App\Models\Academic\Administration\Teacher;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\StudentTest;
use App\Models\Master\Person;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActivityTestCorrectStudent extends Component
{
    public $course;
    public $topic;
    public $activity_id;
    public $activity;
    public $students;
    public $student_names;
    public $exam = [];

    public function mount($course,$topic,$activity){
        $this->course = $course;
        $this->activity_id = $activity;
        $this->topic = $topic;

    }

    public function render()
    {
        $this->studentList();
        return view('livewire.academic.subjects.activity-test-correct-student');
    }

    public function studentList(){

        $teacher = Teacher::where('person_id',Auth::user()->person_id)->first();
        $teacher_id = $teacher->id;

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
                    ->join('cadastre_courses',function($join){
                        $join->on('cadastres.id','cadastre_courses.cadastre_id')
                            ->on('cadastre_courses.course_id','academic_charges.course_id');
                    })
                    ->join('course_topics',function($join){
                        $join->on('academic_charges.course_id','course_topics.course_id')
                            ->on('cadastre_courses.course_id','academic_charges.course_id');
                    })
                    ->join('topic_classes','course_topics.id','topic_classes.course_topic_id')
                    ->join('class_activities','topic_classes.id','class_activities.topic_class_id')
                    ->join('people','cadastres.person_id','people.id')
                    ->leftJoin('users','people.id','users.person_id')
                    ->leftJoin('student_tests',function($join){
                        $join->on('class_activities.id','student_tests.class_activitie_id')
                            ->on('users.id','student_tests.user_id');
                    })
                    ->select(
                        'people.id AS person_id',
                        'people.trade_name',
                        'academic_charges.course_id',
                        'users.id AS user_id',
                        'users.name AS user_name',
                        'users.profile_photo_path AS avatar',
                        'class_activities.description',
                        'class_activities.id AS activity_id',
                        'student_tests.score',
                        'student_tests.id',
                        'student_tests.state'
                    )
                    ->where('academic_charges.course_id',$this->course)
                    ->where('class_activities.id',$this->activity_id)
                    ->where('teacher_courses.teacher_id',$teacher_id)
                    ->where('course_topics.course_id',$this->course)
                    ->get();

    }

    public function examenShow($person_id,$activity_id){
        $student = Student::where('id_person',$person_id)->first();
        $this->exam = ClassActivity::join('class_activity_test_questions','class_activities.id','class_activity_test_questions.class_activity_id')
                        ->join('student_tests','class_activities.id','student_tests.class_activitie_id')
                        ->leftJoin('student_test_answers', function($join){
                            $join->on('student_tests.id','student_test_answers.student_test_id')
                                ->on('class_activities.id','student_test_answers.class_activitie_id')
                                ->on('class_activity_test_questions.id','student_test_answers.class_activity_test_question_id');
                        })
                        ->where('student_tests.student_id',$student->id)
                        ->where('student_tests.class_activitie_id',$activity_id)
                        ->select(
                            'class_activity_test_questions.id',
                            'class_activity_test_questions.question_text',
                            'student_test_answers.id AS answer_id',
                            'student_test_answers.answer_text',
                            'student_tests.state',
                            'class_activity_test_questions.question_type',
                            'student_test_answers.point',
                            DB::raw('(SELECT answer_text FROM class_activity_test_answers WHERE class_activity_test_answers.id = student_test_answers.class_activity_test_answer_id) AS exam_answer_text'),
                            DB::raw('(SELECT correct FROM class_activity_test_answers WHERE class_activity_test_answers.id = student_test_answers.class_activity_test_answer_id) AS exam_answer_correct')
                        )
                        ->orderby('class_activity_test_questions.id')
                        ->get();
    }

    public function examenFail($activitie_id,$person_id){

        $student = Student::where('id_person',$person_id)->first();
        $user = User::where('person_id',$person_id)->first();

        StudentTest::create([
            'class_activitie_id' => $activitie_id,
            'student_id' => $student->id,
            'user_id' => $user->id,
            'score' => 0,
            'state' => 'ausente'
        ]);
    }
}
