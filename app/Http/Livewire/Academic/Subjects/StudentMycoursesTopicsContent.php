<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Models\Academic\Administration\Course;
use App\Models\Academic\Subjects\ClassActivity;
use App\Models\Academic\Subjects\CourseTopic;
use App\Models\Academic\Subjects\TopicClass;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StudentMycoursesTopicsContent extends Component
{
    public $course_id;
    public $course_topics = [];
    public $cadastre_id;

    public function mount($course_id,$cadastre_id){
        $this->course_id = $course_id;
        $this->cadastre_id = $cadastre_id;
    }

    public function render()
    {
        $this->courseTopicsList();
        return view('livewire.academic.subjects.student-mycourses-topics-content');
    }
    // public function courseTopicsList(){
    //     $this->course_topics = [];

    //     $course_topics = DB::select('CALL sp_acd_consult_topic_details(?,?,?)',array(2,$this->course_id,$this->cadastre_id));

    //     foreach($course_topics as $key => $course_topic){
    //         $this->course_topics[$key] = [
    //             'id' => $course_topic->id,
    //             'title' => $course_topic->title,
    //             'course_id' => $course_topic->course_id,
    //             'number' => $course_topic->number,
    //             'state' => $course_topic->state,
    //             'topic_classes' => json_decode($course_topic->topic_classes)
    //         ];
    //     }
    // }

    public function courseTopicsList(){
        $this->course_topics = [];

        $course = Course::find($this->course_id);

        $level = $course->academic_level_id;
        $year = $course->academic_year_id;

        $course_topics = [];

        

        if($level && $year){
            $course_topics  = CourseTopic::select(
                    'course_topics.id',
                    'course_topics.title',
                    'course_topics.course_id',
                    'course_topics.number',
                    'course_topics.state'
                )
                ->join('cadastres','course_topics.course_id','cadastres.course_id')
                ->where('course_topics.course_id',$this->course_id)
                ->where('cadastres.id',$this->cadastre_id)
                ->get();
        }else{
            $course_topics  = CourseTopic::select(
                    'course_topics.id',
                    'course_topics.title',
                    'course_topics.course_id',
                    'course_topics.number',
                    'course_topics.state'
                )
                ->join('cadastre_courses','course_topics.course_id','cadastre_courses.course_id')
                ->where('course_topics.course_id',$this->course_id)
                ->where('cadastre_courses.cadastre_id',$this->cadastre_id)
                ->get();
        }
        
        
        foreach($course_topics as $key => $course_topic){
            $topic_classes = TopicClass::where('course_topic_id',$course_topic->id)->get();
            $topicClasses = [];
            //dd($topic_classes);
            if($topic_classes){
                foreach($topic_classes as $k => $topic_classe){

                    $class_activities = ClassActivity::select(
                            'class_activities.id',
                            'class_activities.description',
                            'class_activities.body',
                            'class_activities.state',
                            'class_activities.academic_type_activitie_id',
                            'academic_type_activities.description AS academic_type_activitie',
                            'class_activities.number'
                        )
                        ->join('academic_type_activities','class_activities.academic_type_activitie_id','academic_type_activities.id')
                        ->where('topic_class_id',$topic_classe->id)
                        ->get();

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
                        'class_activities' =>  ($class_activities?$class_activities: null)
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
}
