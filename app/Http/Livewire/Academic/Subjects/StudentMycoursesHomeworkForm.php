<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\ClassActivityHomework;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StudentMycoursesHomeworkForm extends Component
{

    public $cu,$mt,$code;
    public $activity;
    public $activity_id;
    public $description;
    public $activity_homework;
    public $activity_homework_id;

    public function mount($cu,$mt,$code){
        $this->$cu = $cu;
        $this->mt = $mt;
        $this->code = $code;
        $this->activity_id = (explode('*',mydecrypt($code)))[0];

        $this->activity = ClassActivity::join('users','class_activities.user_id','users.id')
                ->select(
                    'class_activities.id',
                    'class_activities.description',
                    'class_activities.body',
                    'class_activities.created_at',
                    'class_activities.date_start',
                    'class_activities.date_end',
                    'users.id AS user_id',
                    'users.email',
                    'users.profile_photo_path',
                    'users.name',
                    DB::raw('(SELECT points FROM class_activity_homework WHERE class_activity_homework.person_id='.Auth::user()->person_id.' AND class_activity_homework.class_activity_id=class_activities.id and class_activity_homework.class_activity_homework_id IS NULL) AS points')
                )
                ->where('class_activities.id',$this->activity_id)
                ->first();

                //dd($this->activity);
    }
    public function render()
    {
        $this->activity_homework = ClassActivityHomework::where('user_id',Auth::id())
                    ->where('person_id',Auth::user()->person_id)
                    ->where('course_id',$this->cu)
                    ->where('class_activity_id',$this->activity_id)
                    ->whereNull('class_activity_homework_id')
                    ->first();
        if($this->activity_homework){
            $this->description = $this->activity_homework->description;
            $this->activity_homework_id = $this->activity_homework->id;
        }


        return view('livewire.academic.subjects.student-mycourses-homework-form');
    }

    public function store(){

        $this->validate([
            'description' => 'required|max:500'
        ]);

        $this->activity_homework = ClassActivityHomework::create([
            'user_id' => Auth::id(),
            'person_id' => Auth::user()->person_id,
            'course_id' => $this->cu,
            'class_activity_id' => $this->activity_id,
            'description' => $this->description
        ]);
    }

    public function delete(){
        ClassActivityHomework::find($this->activity_homework->id)->delete();
    }

    public function finish(){
        ClassActivityHomework::find($this->activity_homework->id)->update([
            'state' => 'T'
        ]);
        return redirect()->route('subjects_student_mycourse_themes',[$this->cu,$this->mt]);
    }
}
