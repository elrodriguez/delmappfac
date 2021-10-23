<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicCharge;
use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\AcademicSection;
use App\Models\Academic\Administration\AcademicYear;
use App\Models\Academic\Administration\Course;
use App\Models\Master\Parameter;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CourseCreateForm extends Component
{
    public $PRT0001GN;
    public $levels;
    public $years = [];
    public $sections;

    public $level_id;
    public $year_id;
    public $section_id;
    public $description;
    public $state = 1;

    public function mount(){
        $this->levels = AcademicLevel::all();
        $this->sections = AcademicSection::all();
        $this->PRT0001GN = Parameter::where('id_parameter','PRT0001GN')->first();
    }
    public function render()
    {
        return view('livewire.academic.administration.course-create-form');
    }

    public function store(){
        $this->validate([
            'description' => 'required|min:3|max:255'
        ]);

        Course::create([
            'academic_level_id' => $this->level_id,
            'academic_year_id' => $this->year_id,
            'academic_section_id' => $this->section_id,
            'description' => $this->description,
            'state' => ($this->state?$this->state:0)
        ]);

        $this->dispatchBrowserEvent('response_success_courses', ['message' => Lang::get('messages.successfully_registered')]);
        $this->clearForm();
    }

    public function clearForm(){
        $this->level_id = null;
        $this->year_id = null;
        $this->section_id = null;
        $this->description = null;
        $this->state = 1;
    }

    public function loadYears(){
        $this->years = AcademicYear::where('academic_level_id',$this->level_id)->get();
    }
}
