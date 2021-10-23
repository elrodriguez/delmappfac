<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\Student;
use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\ClassActivityTestAnswer;
use App\Models\Academic\Subjects\ClassActivityTestQuestion;
use App\Models\Academic\Subjects\StudentTest;
use App\Models\Academic\Subjects\StudentTestAnswers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StudentMycoursesExamContent extends Component
{
    public $cu;
    public $mt;
    public $code;
    public $questions;
    public $exam = [];
    public $exam_id;
    public $student_test;
    public $start;
    public $student;
    public $total;

    public function mount($cu,$mt,$code){
        $this->cu = $cu;
        $this->mt = $mt;
        $this->code = $code;
        $this->exam_id = (explode('*',mydecrypt($code)))[0];

        $this->student = Student::where('id_person',Auth::user()->person_id)->first();

    }
    public function render()
    {
        $this->exam();
        $this->student_test = StudentTest::where('class_activitie_id',$this->exam_id)
                ->where('user_id',Auth::id())
                ->where('student_id',$this->student->id)
                ->first();

        if($this->student_test){
            $this->total =  $this->student_test->score;
            $dt = Carbon::parse($this->student_test->created_at);
            list($hours,$minutes,$seconds) = explode(':',$this->exam['duration']);
            $dt->addHours($hours);
            $this->start = $dt->addMinutes($minutes);

            $date_time_now = strtotime(date('Y-m-d H:i:s'));
            if(strtotime($this->start)<=$date_time_now && $this->student_test->state == null){
                $this->defeated();
            }else{
                $this->questions();
            }
        }
        return view('livewire.academic.subjects.student-mycourses-exam-content');
    }

    public function exam(){
        $student_id = Student::where('id_person',Auth::user()->person_id)->value('id');
        $this->exam = ClassActivity::where('id',$this->exam_id)
                ->select(
                    'class_activities.id',
                    'class_activities.description',
                    'class_activities.body',
                    'class_activities.state',
                    'class_activities.number',
                    'class_activities.academic_type_activitie_id',
                    'class_activities.topic_class_id',
                    'class_activities.user_id',
                    'class_activities.date_start',
                    'class_activities.date_end',
                    'class_activities.duration',
                    DB::raw('(SELECT score FROM student_tests WHERE student_tests.student_id='.$student_id.' AND student_tests.class_activitie_id=class_activities.id) AS score')
                )
                ->first();
    }

    public function startExamStudent(){
        StudentTest::create([
            'class_activitie_id' => $this->exam_id,
            'student_id' => $this->student->id,
            'user_id' => Auth::id()
        ]);
    }

    public function questions(){
        $questions = ClassActivityTestQuestion::where('class_activity_id',$this->exam_id)
            ->select(
                'id',
                'class_activity_id',
                'question_text',
                'points',
                'question_type'
            )
            ->orderBy(DB::raw('RAND()'))
            ->get();

        foreach($questions as $key => $question){
            $replied = [];
            $answers = [];
            if($question->question_type == 'radio' || $question->question_type == 'checkbox'){
                $array = ClassActivityTestAnswer::where('class_activity_test_question_id',$question->id)->get();
                foreach($array as $k => $item){
                    $answers[$k] = [
                        'id' => $item->id,
                        'answer_text' => $item->answer_text,
                        'correct' => $item->correct
                    ];
                }
                $replied = StudentTestAnswers::where('student_test_id',$this->student_test->id)
                    ->where('class_activitie_id',$this->exam_id)
                    ->where('class_activity_test_question_id',$question->id)
                    ->pluck('class_activity_test_answer_id');
            }else{
                $replied = StudentTestAnswers::where('student_test_id',$this->student_test->id)
                    ->where('class_activitie_id',$this->exam_id)
                    ->where('class_activity_test_question_id',$question->id)
                    ->pluck('answer_text');
            }

            $this->questions[$key] = [
                'id' => $question->id,
                'class_activity_id' => $question->class_activity_id,
                'question_text' => $question->question_text,
                'points' => $question->points,
                'question_type' => $question->question_type,
                'answers' => $answers,
                'replied' => $replied
            ];

        }

    }

    public function storeExamStudent(){
        StudentTestAnswers::where('class_activitie_id',$this->exam_id)
            ->where('student_test_id',$this->student_test->id)
            ->delete();
        //dd($this->questions);
        foreach($this->questions as $question){
            if($question['question_type'] == 'checkbox'){
                if(count($question['replied'])>0){
                    $points = ($question['points']/count($question['replied']));
                    foreach($question['replied'] as $replied){
                        $val = ClassActivityTestAnswer::where('class_activity_test_question_id',$question['id'])
                                    ->where('id',$replied)
                                    ->select('correct')
                                    ->first();
                        StudentTestAnswers::create([
                            'student_test_id' => $this->student_test->id,
                            'class_activitie_id' => $question['class_activity_id'],
                            'class_activity_test_question_id' => $question['id'],
                            'class_activity_test_answer_id' => $replied,
                            'point' => ($val->correct==1?$points:-$points)
                        ]);
                    }
                }
            }elseif($question['question_type'] == 'radio'){
                if($question['replied']){
                    $val = ClassActivityTestAnswer::where('class_activity_test_question_id',$question['id'])
                                    ->where('id',$question['replied'])
                                    ->select('correct')
                                    ->first();

                    StudentTestAnswers::create([
                        'student_test_id' => $this->student_test->id,
                        'class_activitie_id' => $question['class_activity_id'],
                        'class_activity_test_question_id' => $question['id'],
                        'class_activity_test_answer_id' => $question['replied'],
                        'point' => ($val->correct==1?$question['points']:0),
                    ]);
                }
            }else{
                if($question['replied']){
                    StudentTestAnswers::create([
                        'student_test_id' => $this->student_test->id,
                        'class_activitie_id' => $question['class_activity_id'],
                        'class_activity_test_question_id' => $question['id'],
                        'point' => 0,
                        'answer_text' => $question['replied']
                    ]);
                }

            }

        }
        $this->total = StudentTestAnswers::where('class_activitie_id',$this->exam_id)
                ->where('student_test_id',$this->student_test->id)
                ->sum('point');
        $state = '';

        if($this->total>=11){
            $state = 'aprobado';
        }else{
            $state = 'desaprobado';
        }
        StudentTest::find($this->student_test->id)->update(['state'=>$state,'score'=>$this->total]);
    }

    public function defeated(){
        StudentTest::find($this->student_test->id)->update(['state'=>'ausente']);
    }
}
