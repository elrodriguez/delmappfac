<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\AcademicSection;
use App\Models\Academic\Administration\AcademicYear;
use App\Models\Academic\Administration\Course;
use App\Models\Master\Parameter;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CourseEditForm extends Component
{
    public $PRT0001GN;
    public $levels;
    public $years = [];
    public $sections;
    public $course_id;
    public $level_id;
    public $year_id;
    public $section_id;
    public $description;
    public $state = 1;

    public function mount($course_id){
        $this->course_id = $course_id;
        $this->levels = AcademicLevel::all();
        $this->sections = AcademicSection::all();
        $course = Course::find($this->course_id);
        $this->level_id = $course->academic_level_id;
        $this->year_id = $course->academic_year_id;

        if($course->academic_level_id){
            $this->years = AcademicYear::where('academic_level_id',$this->level_id)->get();
        }

        $this->PRT0001GN = Parameter::where('id_parameter','PRT0001GN')->first();
        $this->section_id = $course->academic_section_id;
        $this->description = $course->description;
        $this->state = $course->state;
    }
    public function render()
    {
        return view('livewire.academic.administration.course-edit-form');
    }
    public function update(){
        $this->validate([
            'description' => 'required|min:3|max:255'
        ]);

        Course::where('id',$this->course_id)->update([
            'academic_level_id' => $this->level_id,
            'academic_year_id' => $this->year_id,
            'academic_section_id' => $this->section_id,
            'description' => $this->description,
            'state' => ($this->state?$this->state:0)
        ]);

        $this->dispatchBrowserEvent('response_success_courses', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

    public function loadYears(){
        $this->years = AcademicYear::where('academic_level_id',$this->level_id)->get();
    }
}
