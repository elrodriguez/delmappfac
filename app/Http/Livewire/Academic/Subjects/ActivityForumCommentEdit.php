<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivityComment;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ActivityForumCommentEdit extends Component
{
    public $comment_id;
    public $comment_user_id;
    public $comment_text;
    public $course;
    public $topic;
    public $activity;

    public function mount($course,$topic,$activity,$comment_id){
        $this->course = $course;
        $this->topic = $topic;
        $this->activity = $activity;
        $this->comment_id = $comment_id;
        $comment = ClassActivityComment::where('id',$this->comment_id)->first();
        $this->comment_text = $comment->comment;
        $this->comment_user_id = $comment->user_id;
    }
    public function render()
    {
        return view('livewire.academic.subjects.activity-forum-comment-edit');
    }
    public function update(){
        if($this->comment_text){
            ClassActivityComment::where('id',$this->comment_id)->update([
                'comment' => $this->comment_text
            ]);
            $this->dispatchBrowserEvent('response_success_update_comment', ['message' => Lang::get('messages.was_successfully_updated')]);
        }
    }
}
