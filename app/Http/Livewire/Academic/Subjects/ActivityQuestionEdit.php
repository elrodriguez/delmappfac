<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityQuestionEdit extends Component
{
    public $course;
    public $topic;
    public $activity_id;
    public $activity;

    public $description;
    public $body;
    public $state;

    public function mount($course,$topic,$activity){
        $this->course = $course;
        $this->activity_id = $activity;
        $this->topic = $topic;

        $this->activity = ClassActivity::where('id',$this->activity_id)->first();
        $this->description = $this->activity->description;
        $this->body = htmlspecialchars_decode($this->activity->body, ENT_QUOTES);
        $this->state = $this->activity->state;
    }

    public function render()
    {
        return view('livewire.academic.subjects.activity-question-edit');
    }

    public function update(){
        ClassActivity::where('id',$this->activity_id)->update([
            'description' => $this->description,
            'body' =>  htmlspecialchars($this->body,ENT_QUOTES),
            'state' => $this->state
        ]);
        $this->dispatchBrowserEvent('response_success_activity', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
