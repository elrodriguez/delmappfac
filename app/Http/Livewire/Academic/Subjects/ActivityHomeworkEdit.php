<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityHomeworkEdit extends Component
{
    public $course;
    public $topic;
    public $activity_id;
    public $activity;

    public $description;
    public $body;
    public $state;
    public $date_start;
    public $date_end;
    public $dates;

    public function mount($course,$topic,$activity){
        $this->course = $course;
        $this->activity_id = $activity;
        $this->topic = $topic;

        $this->activity = ClassActivity::where('id',$this->activity_id)->first();
        $this->description = $this->activity->description;
        $this->body = htmlspecialchars_decode($this->activity->body, ENT_QUOTES);
        $this->state = $this->activity->state;
        $this->date_start = $this->activity->date_start;
        $this->date_end = $this->activity->date_end;

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
        return view('livewire.academic.subjects.activity-homework-edit');
    }

    public function update(){
        ClassActivity::where('id',$this->activity_id)->update([
            'description' => $this->description,
            'body' =>  htmlspecialchars($this->body,ENT_QUOTES),
            'state' => $this->state,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end
        ]);
        $this->dispatchBrowserEvent('response_success_activity', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
