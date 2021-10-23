<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\ClassActivityAnswer;
use App\Models\Academic\Subjects\ClassActivityTestAnswer;
use App\Models\Academic\Subjects\ClassActivityTestQuestion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityTestQuestions extends Component
{
    public $course;
    public $topic;
    public $activity_id;
    public $activity;

    public $description;
    public $body;
    public $state;
    public $questions = [];
    public $class_activity_test_question_id;
    public $question_text;
    public $correct;
    public $date_start;
    public $date_end;
    public $dates;
    public $duration;

    public function mount($course,$topic,$activity){
        $this->course = $course;
        $this->activity_id = $activity;
        $this->topic = $topic;

        $this->activity = ClassActivity::where('id',$this->activity_id)->first();
        $this->description = $this->activity->description;
        $this->state = $this->activity->state;

        $this->date_start = $this->activity->date_start;
        $this->date_end = $this->activity->date_end;
        $this->duration = $this->activity->duration;

        if($this->activity->date_start && $this->activity->date_end){
            list($ye,$me,$de) = explode('-',$this->date_start);
            list($yf,$mf,$df) = explode('-',$this->date_end);
            $this->dates = $de.'/'.$me.'/'.$ye.' - '.$df.'/'.$mf.'/'.$yf;
        }else{
            $this->dates = null;
        }

    }

    public function render()
    {
        $this->questionList();
        return view('livewire.academic.subjects.activity-test-questions');
    }

    public function update(){
        ClassActivity::where('id',$this->activity_id)->update([
            'description' => $this->description,
            'state' => $this->state,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'duration' => $this->duration
        ]);
        $this->dispatchBrowserEvent('response_success_activity', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

    public function questionList(){
        $this->questions = [];
        $questions = ClassActivityTestQuestion::where('class_activity_id',$this->activity_id)
                    ->select(
                        'id',
                        'question_text',
                        'points',
                        'question_type',
                        DB::raw("(SELECT CONCAT('[',GROUP_CONCAT(JSON_OBJECT('id',t2.id,'answer_text',t2.answer_text,'correct',t2.correct)),']') FROM class_activity_test_answers AS t2 WHERE t2.class_activity_test_question_id=class_activity_test_questions.id) as answers")
                    )
                    ->get();

        foreach($questions as $c => $question){
            $this->questions[$c] = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'points' => $question->points,
                'question_type' => $question->question_type,
                'answers'  => json_decode($question->answers),
            ];
        }
        //dd($this->questions);
    }

    public function answersStore(){
        $this->validate([
            'question_text' => 'required'
        ]);

        ClassActivityTestAnswer::create([
            'class_activity_test_question_id' => $this->class_activity_test_question_id,
            'answer_text' => $this->question_text,
            'correct' => ($this->correct?$this->correct:0)
        ]);

        $this->question_text = null;
        $this->correct = null;
        $this->dispatchBrowserEvent('response_success_activity_test_answer_store', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

    public function deleteQuestion($id){
        ClassActivityTestQuestion::where('id',$id)->delete();
    }
    public function deleteAnswers($id){
        ClassActivityTestAnswer::where('id',$id)->delete();
    }
}
