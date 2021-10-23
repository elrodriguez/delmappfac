<?php

namespace App\Http\Livewire\Academic\Subjects;

use App\Exports\AssistancesTrainingExport;
use App\Models\Academic\Administration\Teacher;
use App\Models\Academic\Administration\TeacherCourse;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Subjects\CourseAssistanceStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Elrod\UserActivity\Activity;

class CoursesTrainingStudentsAssistance extends Component
{
    public $courses = [];
    public $teacher_id;
    public $index = null;
    public $students = [];
    public $btn_active = false;
    public $date;
    public $assistances = [];
    public $academic_level_id;
    public $academic_year_id;
    public $course_id;
    public $course_name;
    public $assistance_date;
    public $btnsave = false;

    public function mount(){

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('subjects_training_students_assistance'));
        $activity->componentOn('academic.subjects.courses-training-students-assistance');
        $activity->logType('search');
        $activity->log('Ingresó a la vista de registrar asistencia');
        $activity->save();

        $this->teacher_id = Teacher::where('person_id',Auth::user()->person_id)->value('id');
    }

    public function render()
    {
        $this->getCourses();
        return view('livewire.academic.subjects.courses-training-students-assistance');
    }

    public function getCourses(){
        $this->courses = TeacherCourse::join('courses',function($query){
            $query->on('teacher_courses.course_id','courses.id')
                ->on('teacher_courses.academic_level_id','courses.academic_level_id')
                ->on('teacher_courses.academic_year_id','courses.academic_year_id')
                ->whereRaw('IF(teacher_courses.academic_section_id IS NULL,TRUE,teacher_courses.academic_section_id=courses.academic_section_id)');
        })
        ->select(
            'courses.id',
            'courses.description',
            'courses.academic_level_id',
            'courses.academic_year_id',
            'courses.academic_section_id',
            DB::raw('CONCAT(courses.academic_level_id,courses.academic_year_id,IF(courses.academic_section_id IS NULL,"",courses.academic_section_id)) AS lys'),
            DB::raw('(SELECT description FROM academic_levels WHERE academic_levels.id = teacher_courses.academic_level_id) AS level_description'),
            DB::raw('(SELECT description FROM academic_years WHERE academic_years.id = teacher_courses.academic_year_id) AS year_description'),
            DB::raw('(SELECT description FROM academic_sections WHERE academic_sections.id = teacher_courses.academic_section_id) AS section_description')
        )
        ->where('teacher_courses.teacher_id',$this->teacher_id)
        ->where('teacher_courses.state',true)
        ->orderBy('courses.academic_level_id')
        ->orderBy('courses.academic_year_id')
        ->orderBy('courses.academic_section_id')
        ->get()
        ->toArray();

    }

    public function getStudentByCourses($id){

        $key = array_search($id, array_column($this->courses, 'id'));
        $course = $this->courses[$key];
        $this->course_id = $course['id'];
        $this->academic_level_id = $course['academic_level_id'];
        $this->academic_year_id = $course['academic_year_id'];
        $this->course_name = $course['description'];
        $this->inactiveBtnsave();
    }

    public function searchStudents(){

        $this->validate([
            'course_id' => 'required',
            'assistance_date' => 'required'
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('subjects_training_students_assistance'));
        $activity->componentOn('academic.subjects.courses-training-students-assistance');
        $activity->logType('search');
        $activity->log('Realizó una búsqueda con los parametros '.$this->course_name.' y fecha '.$this->assistance_date);
        $activity->save();

        list($d,$m,$y)=explode('/',$this->assistance_date);
        $assistance_date = $y.'-'.$m.'-'.$d;
        $this->students = Cadastre::join('people','cadastres.person_id','people.id')
            ->join('students','students.id_person','people.id')
            ->where('cadastres.academic_level_id',$this->academic_level_id)
            ->where('cadastres.academic_year_id',$this->academic_year_id)
            ->where('cadastres.course_id',$this->course_id)
            ->select(
                'people.id',
                'students.id AS student_id',
                'people.number',
                'people.trade_name',
                'cadastres.academic_level_id',
                'cadastres.academic_year_id',
                'cadastres.academic_section_id',
                'cadastres.course_id',
                DB::raw("(SELECT id FROM course_assistance_students WHERE person_id=people.id AND student_id = students.id AND academic_level_id = cadastres.academic_level_id AND academic_year_id = cadastres.academic_year_id AND course_id = cadastres.course_id AND assistance_date='".$assistance_date."') AS assistance_id"),
                DB::raw("(SELECT IFNULL(attended,false) FROM course_assistance_students WHERE person_id=people.id AND student_id = students.id AND academic_level_id = cadastres.academic_level_id AND academic_year_id = cadastres.academic_year_id AND course_id = cadastres.course_id AND assistance_date='".$assistance_date."') AS attended"),
                DB::raw("(SELECT IFNULL(justified,false)  FROM course_assistance_students WHERE person_id=people.id AND student_id = students.id AND academic_level_id = cadastres.academic_level_id AND academic_year_id = cadastres.academic_year_id AND course_id = cadastres.course_id AND assistance_date='".$assistance_date."') AS justified"),
                DB::raw("(SELECT observation FROM course_assistance_students WHERE person_id=people.id AND student_id = students.id AND academic_level_id = cadastres.academic_level_id AND academic_year_id = cadastres.academic_year_id AND course_id = cadastres.course_id AND assistance_date='".$assistance_date."') AS observation")
            )
            ->orderBy('people.trade_name')
            ->get()
            ->toArray();
        $this->activeBtnsave();
    }

    public function saveAssistance(){

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('subjects_training_students_assistance'));
        $activity->componentOn('academic.subjects.courses-training-students-assistance');
        $activity->logType('create');
        $activity->log('Registro de asistencias para el curso '.$this->course_name);
        $activity->save();

        list($d,$m,$y)=explode('/',$this->assistance_date);
        $assistance_date = $y.'-'.$m.'-'.$d;
        $exists = CourseAssistanceStudent::where('academic_level_id',$this->academic_level_id)
                ->where('academic_year_id',$this->academic_year_id)
                ->where('course_id',$this->course_id)
                ->where('assistance_date',$assistance_date)
                ->exists();

        foreach($this->students as $item){
            if($item['assistance_id']){
                CourseAssistanceStudent::find($item['assistance_id'])->update([
                    'attended' => ($item['attended']?$item['attended']:false),
                    'justified' => ($item['justified']?$item['justified']:false),
                    'observation' => $item['observation']
                ]);
            }else{
                if($exists){
                    CourseAssistanceStudent::find($item['assistance_id'])->update([
                        'attended' => ($item['attended']?$item['attended']:false),
                        'justified' => ($item['justified']?$item['justified']:false),
                        'observation' => $item['observation']
                    ]);
                }else{
                    CourseAssistanceStudent::create([
                        'person_id' => $item['id'],
                        'student_id' => $item['student_id'],
                        'academic_level_id' => $item['academic_level_id'],
                        'academic_year_id' => $item['academic_year_id'],
                        'academic_section_id' => $item['academic_section_id'],
                        'course_id' => $item['course_id'],
                        'assistance_year' => $y,
                        'assistance_month' => $m,
                        'assistance_day' => $d,
                        'assistance_date' => $assistance_date,
                        'attended' => ($item['attended']?$item['attended']:false),
                        'justified' => ($item['justified']?$item['justified']:false),
                        'observation' => $item['observation']
                    ]);
                }
            }
        }
        $this->dispatchBrowserEvent('response_assistance_students_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function activeBtnsave(){
        $this->btnsave = true;
    }
    public function inactiveBtnsave(){
        $this->btnsave = false;
    }

    public function reportAssistance(){

        $this->validate([
            'course_id' => 'required'
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->causedBy($user);
        $activity->routeOn(route('subjects_training_students_assistance'));
        $activity->componentOn('academic.subjects.courses-training-students-assistance');
        $activity->logType('download');
        $activity->log('Descargar reporte de asistencia del curso '.$this->course_name);
        $activity->save();

        $assistances = Cadastre::join('people','cadastres.person_id','people.id')
            ->join('students','students.id_person','people.id')
            ->where('cadastres.academic_level_id',$this->academic_level_id)
            ->where('cadastres.academic_year_id',$this->academic_year_id)
            ->where('cadastres.course_id',$this->course_id)
            ->select(
                'people.number',
                'people.trade_name',
                DB::raw("(SELECT CONCAT('[',GROUP_CONCAT(JSON_OBJECT('year',assistance_year,'month',assistance_month,'day',assistance_day,'date',assistance_date,'attended',attended,'justified',justified,'observation',observation)),']') FROM course_assistance_students WHERE person_id =people.id AND student_id = students.id AND academic_level_id = cadastres.academic_level_id AND academic_year_id = cadastres.academic_year_id AND course_id = cadastres.course_id) AS assistance")
            )
            ->orderBy('people.trade_name')
            ->get()
            ->toArray();

        $filename = "REPORTE_ASISTENCIA_".str_replace(' ','_',$this->course_name);

        return (new AssistancesTrainingExport)
            ->assistances($assistances)
            ->download($filename.'.xlsx');

    }
}
