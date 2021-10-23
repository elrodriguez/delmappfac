<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityEditForm extends Component
{
    public $course;
    public $topic;
    public $activity;
    public $description;
    public $body;
    public $state;

    public function mount($course,$topic,$activity){
        $this->topic = $topic;
        $this->course = $course;
        $this->activity = $activity;
        $data = ClassActivity::find($this->activity);
        $this->description = $data->description;
        $this->body = htmlspecialchars_decode($data->body, ENT_QUOTES);
        $this->state = $data->state;
    }
    public function render()
    {
        return view('livewire.academic.subjects.activity-edit-form');
    }
    public function update(){
        ClassActivity::where('id',$this->activity)->update([
            'description' => $this->description,
            'body' =>  htmlspecialchars($this->body,ENT_QUOTES),
            'state' => $this->state
        ]);
        $this->dispatchBrowserEvent('response_success_activity', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
