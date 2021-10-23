<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivityTestQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityTestQuestionForm extends Component
{
    public $course;
    public $topic;
    public $activity;
    public $question_text = null;
    public $points;
    public $question_type;
    public $question_id = null;

    public function mount($course,$topic,$activity,$question = null){
        $this->course = $course;
        $this->topic = $topic;
        $this->activity = $activity;

        if($question){
            $this->question_id = $question;
            $question_data = ClassActivityTestQuestion::find($question);
            $this->question_text = htmlspecialchars_decode($question_data->question_text, ENT_QUOTES);
            $this->points = $question_data->points;
            $this->question_type = $question_data->question_type;
        }
    }
    public function render()
    {
        return view('livewire.academic.subjects.activity-test-question-form');
    }

    public function store(){
        if($this->question_text){
            $this->validate([
                'points' => 'required|numeric',
                'question_type' => 'required'
            ]);

            ClassActivityTestQuestion::create([
                'user_id' => Auth::id(),
                'person_id' => Auth::user()->person_id,
                'course_id' => $this->course,
                'class_activity_id' => $this->activity,
                'question_text' => $this->question_text,
                'points' => $this->points,
                'question_type' => $this->question_type
            ]);
            $this->question_text = null;
            $this->points = null;
            $this->question_type = null;
            $this->dispatchBrowserEvent('response_success_activity_test_question_store', ['message' => Lang::get('messages.successfully_registered')]);
        }
    }

    public function update(){

        if($this->question_text){
            $this->validate([
                'points' => 'required|numeric',
                'question_type' => 'required'
            ]);

            ClassActivityTestQuestion::where('id',$this->question_id)->update([
                'user_id' => Auth::id(),
                'person_id' => Auth::user()->person_id,
                'question_text' => $this->question_text,
                'points' => $this->points,
                'question_type' => $this->question_type
            ]);

            $this->dispatchBrowserEvent('response_success_activity_test_question_store', ['message' => Lang::get('messages.was_successfully_updated')]);
        }
    }
}
