<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\ClassActivityComment;
use App\Models\Academic\Subjects\ClassActivityCommentLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class StudentMycoursesForumComments extends Component
{
    public $cu;
    public $mt;
    public $code;
    public $activity;
    public $activity_id;
    public $comment;
    public $heart = 0;
    public $comments = [];
    public $user_editor;
    public $comment_id;
    public $editcomment = false;

    public function mount($cu,$mt,$code){
        $this->cu = $cu;
        $this->mt = $mt;
        $this->code = $code;
        $this->activity_id = (explode('*',mydecrypt($code)))[0];
        $this->activity = ClassActivity::join('users','class_activities.user_id','users.id')
                ->select(
                    'class_activities.id',
                    'class_activities.description',
                    'class_activities.body',
                    'class_activities.created_at',
                    'users.id AS user_id',
                    'users.email',
                    'users.profile_photo_path',
                    'users.name'
                )
                ->where('class_activities.id',$this->activity_id)
                ->first();
    }

    public function render()
    {
        $this->commentList();
        return view('livewire.academic.subjects.student-mycourses-forum-comments');
    }

    public function heartChecked(){
        if($this->heart == 0){
            $this->heart = 1;
        }else{
            $this->heart = 0;
        }
    }
    public function store(){
        if($this->comment != null){
            ClassActivityComment::create([
                'user_id' => Auth::id(),
                'person_id' => Auth::user()->person_id,
                'class_activity_id' => $this->activity->id,
                'comment' => htmlspecialchars($this->comment,ENT_QUOTES),
                'likes' => 0,
                'heart' => $this->heart
            ]);
            $this->heart = 0;
            $this->comment = null;
            $this->dispatchBrowserEvent('response_success_activity_comment', ['message' => Lang::get('messages.was_successfully_updated')]);

        }
    }

    public function toLike($id){
        $like = ClassActivityCommentLike::where('class_activity_comment_id',$id)
                ->where('user_id',Auth::id())
                ->first();
        if(!$like){
            ClassActivityCommentLike::create([
                'class_activity_comment_id' => $id,
                'user_id' => Auth::id()
            ]);
            ClassActivityComment::where('id',$id)->increment('likes');
        }
    }

    public function ilove($id){
        ClassActivityComment::where('id',$id)->update(['heart'=>true]);
    }

    public function delete($id){
        ClassActivityComment::where('id',$id)->delete();
    }

    public function commentList(){
        $this->comments = ClassActivityComment::join('users','class_activity_comments.user_id','users.id')
                        ->join('people','class_activity_comments.person_id','people.id')
                        ->where('class_activity_id',$this->activity->id)
                        ->select(
                            'class_activity_comments.id',
                            'class_activity_comments.comment',
                            'class_activity_comments.heart',
                            'class_activity_comments.likes',
                            'users.profile_photo_path',
                            'users.email',
                            'users.name',
                            'users.id AS user_id',
                            'people.trade_name',
                            'class_activity_comments.created_at',
                            DB::raw("(SELECT CONCAT('[',GROUP_CONCAT(JSON_OBJECT('name',users.name,'avatar',users.profile_photo_path)),']') FROM class_activity_comment_likes INNER JOIN users ON class_activity_comment_likes.user_id=users.id WHERE class_activity_comment_likes.class_activity_comment_id=class_activity_comments.id) AS user_likes")
                        )
                        ->get();
    }
}
