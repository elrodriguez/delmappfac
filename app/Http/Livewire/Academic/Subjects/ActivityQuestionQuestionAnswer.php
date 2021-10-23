<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\ClassActivityAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActivityQuestionQuestionAnswer extends Component
{
    public $course,$topic,$activity;
    public $answers = [];
    public $user_editor;

    public function mount($course,$topic,$activity){
        $this->$course = $course;
        $this->topic = $topic;
        $this->activity = $activity;
        $this->user_editor = ClassActivity::where('id',$this->activity)->first();
    }
    public function render()
    {
        $this->answersList();
        return view('livewire.academic.subjects.activity-question-question-answer');
    }

    public function answersList(){
        $answers = ClassActivityAnswer::join('users','class_activity_answers.user_id','users.id')
            ->join('people','class_activity_answers.person_id','people.id')
            ->where('class_activity_id',$this->activity)
            ->whereNull('class_activity_answer_id')
            ->select(
                'class_activity_answers.id',
                'class_activity_answers.answer_text',
                'class_activity_answers.points',
                'users.profile_photo_path',
                'users.email',
                'users.name',
                'users.id AS user_id',
                'people.trade_name',
                'class_activity_answers.created_at',
                DB::raw("(SELECT CONCAT('[',GROUP_CONCAT(JSON_OBJECT('email',users.email,'name',users.name,'avatar',users.profile_photo_path,'answer_text',t2.answer_text,'created_at',t2.created_at)),']') FROM class_activity_answers AS t2 INNER JOIN users ON t2.user_id=users.id WHERE t2.class_activity_answer_id=class_activity_answers.id) AS answers")
            )
            ->get();
        $items = [];

        foreach($answers as $c => $answer){
            $subitems = [];
            if($answer->answers){
                foreach(json_decode($answer->answers) as $i => $item){
                    $subitems[$i] = [
                        'name' => $item->name,
                        'avatar' => $item->avatar,
                        'email' => $item->email,
                        'created_at' => $item->created_at,
                        'answer_text' => $item->answer_text,
                        'answers_new' => false
                    ];
                }
                array_push($subitems, [
                    'name' => Auth::user()->name,
                    'avatar' => Auth::user()->profile_photo_path,
                    'email' => Auth::user()->email,
                    'created_at' => null,
                    'answer_text' => null,
                    'answers_new' => true
                ]);
            }else{
                $subitems[0] = [
                    'name' => Auth::user()->name,
                    'avatar' => Auth::user()->profile_photo_path,
                    'email' => Auth::user()->email,
                    'created_at' => null,
                    'answer_text' => null,
                    'answers_new' => true
                ];
            }
            $items[$c] = [
                'id' => $answer->id,
                'answer_text' => $answer->answer_text,
                'points' => $answer->points,
                'profile_photo_path' => $answer->profile_photo_path,
                'email' => $answer->email,
                'name' => $answer->name,
                'user_id' => $answer->user_id,
                'trade_name' => $answer->trade_name,
                'created_at' => $answer->created_at,
                'answers' => $subitems
            ];
        }

        $this->answers = $items;

    }
    public function answerStore($c,$i){
        $answer = $this->answers[$c];
        //dd($answer['answers'][$i]);
        $subanswer = $answer['answers'][$i];

        ClassActivityAnswer::where('id',$answer['id'])->update(['points'=>$answer['points']]);
        ClassActivityAnswer::create([
            'user_id' => Auth::user()->id,
            'person_id' => Auth::user()->person_id,
            'class_activity_id' => $this->activity,
            'class_activity_answer_id' => $answer['id'],
            'answer_text' => $subanswer['answer_text'],
            'points' => 0
        ]);
    }
}
