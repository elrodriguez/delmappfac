<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Subjects\AcademicTypeActivity;
use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\CourseTopic;
use App\Models\Academic\Subjects\TopicClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Vimeo\Laravel\Facades\Vimeo;
use Livewire\Component;

class CoursesTopicsContent extends Component
{

    public $title;
    public $course_id;
    public $course_topics = [];
    public $topic_id;
    public $class_id;
    public $class_title;
    public $class_date_start;
    public $class_date_end;
    public $class_start_type = 'AM';
    public $class_end_type = 'AM';
    public $class_time_start;
    public $class_time_end;
    public $activity_title;
    public $activity_type_id;
    public $activity_types;
    public $teacher_course_id;

    public function mount($course_id,$teacher_course_id){
        $this->course_id = $course_id;
        $this->teacher_course_id = $teacher_course_id;
    }
    public function render()
    {
        $this->courseTopicsList();
        $this->activity_types = AcademicTypeActivity::all();
        return view('livewire.academic.subjects.courses-topics-content');
    }

    public function store(){

        $this->validate([
            'title' => 'required'
        ]);

        $max = CourseTopic::where('course_id',$this->course_id)->max('number');
        $number = ($max == null?0:$max);

        CourseTopic::create([
            'title' => $this->title,
            'course_id' => $this->course_id,
            'number' => ($number+1),
            'user_id' => Auth::id(),
            'person_id' => Auth::user()->person_id,
            'teacher_course_id' => $this->teacher_course_id
        ]);

        $this->title = null;

        $this->dispatchBrowserEvent('response_course_topic_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function courseTopicsList(){
        $this->course_topics = [];

        //$course_topics = DB::select('call sp_acd_consult_topic_details(?,?,?)',array(1,$this->course_id,$this->teacher_course_id));

        $course_topics  = CourseTopic::where('course_id',$this->course_id)
            ->where('teacher_course_id',$this->teacher_course_id)
            ->get();

        foreach($course_topics as $key => $course_topic){
            $topic_classes = TopicClass::where('course_topic_id',$course_topic->id)->get();
            $topicClasses = [];
            if($topic_classes){
                foreach($topic_classes as $k => $topic_classe){
                    $classActivities = [];
                    $class_activities = ClassActivity::select(
                            'class_activities.id',
                            'class_activities.description',
                            'class_activities.body',
                            'class_activities.state',
                            'class_activities.academic_type_activitie_id',
                            'academic_type_activities.description AS academic_type_activitie',
                            'class_activities.number',
                            'class_activities.url_file',
                            'class_activities.name_file',
                            'class_activities.extension',

                        )
                        ->join('academic_type_activities','class_activities.academic_type_activitie_id','academic_type_activities.id')
                        ->where('topic_class_id',$topic_classe->id)
                        ->get();

                        if($class_activities){
                            foreach($class_activities as $i => $class_activitie){
                                if($class_activitie->academic_type_activitie_id == 6){
                                    if($class_activitie->url_file){
                                        $file = Vimeo::request('/me'.$class_activitie->url_file);
                                    }else{
                                        $file = [];
                                    }
                                }else{
                                    $file = $class_activitie->url_file;
                                }
                                
                                $classActivities[$i] = (object) [
                                    'id' => $class_activitie->id,
                                    'description' => $class_activitie->description,
                                    'body' => $class_activitie->body,
                                    'state' => $class_activitie->state,
                                    'academic_type_activitie_id' => $class_activitie->academic_type_activitie_id,
                                    'academic_type_activitie' => $class_activitie->academic_type_activitie,
                                    'number' => $class_activitie->number,
                                    'file' => $file,
                                    'name_file' => $class_activitie->name_file,
                                    'extension' => $class_activitie->extension
                                ];
                            }
                        }

                    $topicClasses[$k] = (object) [
                        'id' => $topic_classe->id,
                        'title' => $topic_classe->title,
                        'date_start' => $topic_classe->date_start,
                        'date_end' => $topic_classe->date_end,
                        'time_start' => $topic_classe->date_end,
                        'time_end' => $topic_classe->date_end,
                        'state' => $topic_classe->date_end,
                        'live' => $topic_classe->date_end,
                        'number' => $topic_classe->number,
                        'class_activities' =>  $classActivities
                    ];
                }
            }

            $this->course_topics[$key] =  [
                'id' => $course_topic->id,
                'title' => $course_topic->title,
                'course_id' => $course_topic->course_id,
                'number' => $course_topic->number,
                'state' => $course_topic->state,
                'topic_classes' => $topicClasses
            ];
        }
        //dd($this->course_topics);
    }


    public function changenumber($direction,$id,$number,$index){
        if($direction == 1){
            $move = CourseTopic::where('id',$id);
            $change_array = $this->course_topics[$index-1];
            $change = CourseTopic::where('id',$change_array['id']);

            $move->update([
                'number' => $number-1
            ]);

            $change->update([
                'number' => $number
            ]);
        }else if($direction == 0){
            $move = CourseTopic::where('id',$id);
            $change_array = $this->course_topics[$index+1];
            $change = CourseTopic::where('id',$change_array['id']);

            $move->update([
                'number' => $number+1
            ]);

            $change->update([
                'number' => $number
            ]);
        }

    }

    public function deleteItem($id,$number){
        $max = CourseTopic::where('course_id',$this->course_id)->max('number');
        $exists = TopicClass::where('course_topic_id',$id)->first();

        if($exists){
            $this->dispatchBrowserEvent('response_success_delete_topics', ['message' => Lang::get('messages.msg_notdelete_tca')]);
        }else{
            CourseTopic::where('id',$id)->delete();
            $this->package_item_details = [];
            for($c = $number;$c <=$max; $c++){
                CourseTopic::where('course_id',$this->course_id)
                        ->where('number',$c)
                        ->update([
                            'number' => $c - 1
                        ]);
            }

        }

    }

    public function classStore(){
        $this->validate([
            'class_title' => 'required'
        ]);

        $max = TopicClass::where('course_topic_id',$this->topic_id)->max('number');
        $number = ($max == null? 0 : $max);

        TopicClass::create([
            'title' => $this->class_title,
            'date_start' => $this->class_date_start,
            'date_end' => $this->class_date_end,
            'time_start' => ($this->class_time_start ? $this->class_time_start.'|'.$this->class_start_type:null ),
            'time_end' => ($this->class_time_end ? $this->class_time_end.'|'.$this->class_end_type:null) ,
            'course_topic_id' => $this->topic_id,
            'number' => ($number+1)
        ]);

        $this->class_title = null;
        $this->class_date_start = null;
        $this->class_date_end = null;
        $this->class_time_start = null;
        $this->class_time_end = null;
        $this->dispatchBrowserEvent('response_course_topic_class_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function activityStore(){
        $this->validate([
            'activity_title' => 'required',
            'activity_type_id' => 'required'
        ]);

        $max = ClassActivity::where('topic_class_id',$this->class_id)->max('number');
        $number = ($max == null? 0 : $max);

        ClassActivity::create([
            'topic_class_id' => $this->class_id,
            'description' => $this->activity_title,
            'academic_type_activitie_id' => $this->activity_type_id,
            'number' => ($number+1),
            'user_id' => Auth::id()
        ]);

        $this->activity_title = null;
        $this->activity_type_id = null;
        $this->dispatchBrowserEvent('response_course_topic_class_activity_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function deleteActivity($id){
        ClassActivity::where('id',$id)->delete();
    }
}
