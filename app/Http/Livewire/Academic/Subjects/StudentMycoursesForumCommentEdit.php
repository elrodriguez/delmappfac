<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivityComment;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class StudentMycoursesForumCommentEdit extends Component
{
    public $comment_id;
    public $comment_user_id;
    public $comment_text;
    public $cu;
    public $mt;
    public $code;

    public function mount($cu,$mt,$code,$comment_id){
        $this->cu = $cu;
        $this->mt = $mt;
        $this->code = $code;
        $this->comment_id = $comment_id;
        $comment = ClassActivityComment::where('id',$this->comment_id)->first();
        $this->comment_text = $comment->comment;
        $this->comment_user_id = $comment->user_id;
    }

    public function render()
    {
        return view('livewire.academic.subjects.student-mycourses-forum-comment-edit');
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
