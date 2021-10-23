<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\AcademicCharge;
use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\AcademicSeason;
use App\Models\Academic\Administration\AcademicSection;
use App\Models\Academic\Administration\AcademicYear;
use App\Models\Academic\Administration\Curricula;
use Illuminate\Validation\Rule;
use App\Models\Master\Parameter;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AcademicChargesForm extends Component
{
    public $PRT0001GN;
    public $levels;
    public $years;
    public $sections;
    public $academic_charges = [];

    public $level_id;
    public $year_id;
    public $section_id;
    public $course_id;

    public function mount($course_id){
        $this->course_id = $course_id;
        $this->levels = AcademicLevel::all();
        $this->years = AcademicYear::all();
        $this->sections = AcademicSection::all();
        $this->PRT0001GN = Parameter::where('id_parameter','PRT0001GN')->first();
        $this->listAssignments();
    }

    public function render()
    {
        return view('livewire.academic.administration.academic-charges-form');
    }

    public function store(){
        $this->validate([
            'level_id'=>'required',
            'year_id'=>'required',
            'section_id'=> ['required', Rule::unique('academic_charges','academic_section_id')->where(function ($query) {
                $query->where('academic_level_id', $this->level_id)
                ->where('academic_year_id', $this->year_id)
                ->where('course_id', $this->course_id)
                ->whereNull('academic_charges.deleted_at');
            }) ]
        ]);

        $curricula = Curricula::where('state',1)->first();
        $season = AcademicSeason::where('state',1)->first();

        if($this->section_id == 1){
            foreach($this->sections as $item_section){
                if($item_section->id != 1){
                    AcademicCharge::create([
                        'academic_level_id' => $this->level_id,
                        'academic_year_id' => $this->year_id,
                        'academic_section_id' => $item_section->id,
                        'course_id' => $this->course_id,
                        'academic_season_id' => $season->id,
                        'curricula_id' => $curricula->id
                    ]);
                }
            }
        }else{
            AcademicCharge::create([
                'academic_level_id' => $this->level_id,
                'academic_year_id' => $this->year_id,
                'academic_section_id' => $this->section_id ,
                'course_id' => $this->course_id,
                'curricula_id' => $curricula->id
            ]);
        }

        $this->listAssignments();
        $this->clearForm();
    }

    public function clearForm(){
        $this->level_id = null;
        $this->year_id = null;
        $this->section_id = null;
    }

    public function listAssignments(){
        $this->academic_charges = AcademicCharge::join('academic_levels','academic_charges.academic_level_id','academic_levels.id')
            ->join('academic_sections','academic_charges.academic_section_id','academic_sections.id')
            ->join('academic_years','academic_charges.academic_year_id','academic_years.id')
            ->select(
                'academic_charges.id',
                'academic_levels.description AS academic_level_description',
                'academic_sections.description AS academic_section_description',
                'academic_years.description AS academic_year_description',
                'academic_charges.created_at'
            )
            ->where('academic_charges.course_id',$this->course_id)
            ->get();
    }

    public function removeAssignment($id){
        AcademicCharge::where('id',$id)->delete();
        $this->listAssignments();
    }
}
