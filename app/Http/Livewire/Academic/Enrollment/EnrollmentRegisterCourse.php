<?php

namespace App\Http\Livewire\Academic\Enrollment;

use App\Models\Academic\Administration\AcademicLevel;
use App\Models\Academic\Administration\AcademicYear;
use App\Models\Academic\Administration\Course;
use App\Models\Academic\Administration\Package;
use App\Models\Academic\Administration\PackageItemDetail;
use App\Models\Academic\Enrollment\Cadastre;
use App\Models\Academic\Enrollment\StudentPaymentCommitments;
use App\Models\Master\Document;
use App\Models\Master\Person;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class EnrollmentRegisterCourse extends Component
{
    public $docmuent_serie;
    public $docmuent_number;
    public $date_register;
    public $level_id;
    public $year_id;
    public $course_id;
    public $courses = [];
    public $levels;
    public $years = [];
    public $representative_id = null;
    public $representative_name;
    public $packages;
    public $package_id;
    public $docmuent_id;
    public $state = 1;
    public $btn_see = false;
    public $number_search;
    public $student_id;
    public $student_name;
    public $observation;
    public $student_cod;
    public $external_id;

    public function render()
    {
        $this->levels = AcademicLevel::all();
        $this->packages = Package::all();
        return view('livewire.academic.enrollment.enrollment-register-course');

    }

    public function  loadYears(){
        $this->years = AcademicYear::where('academic_level_id',$this->level_id)->get();
    }

    public function loadCourses(){
        $this->courses = Course::where('academic_level_id',$this->level_id)
            ->where('academic_year_id',$this->year_id)
            ->get();
    }

    public function searchDocument(){

        $document = Document::where('series',$this->docmuent_serie)
            ->where('number',$this->docmuent_number)
            ->first();

        if($document){
            if($document->used == 0){
                $this->docmuent_id = $document->id;
                $this->btn_see = true;
                $this->external_id = $document->external_id;
            }else{
                $this->docmuent_serie = null;
                $this->docmuent_number = null;
                $this->external_id = null;
                $this->dispatchBrowserEvent('response_fail_search_document', ['message' => Lang::get('messages.it_was_already_used_in_a_previous_license_plate')]);
            }
        }else{
            $this->dispatchBrowserEvent('response_fail_search_document', ['message' => Lang::get('messages.no_data_available')]);
        }

    }
    public function searchStudent(){
        $student = Person::join('students','people.id','students.id_person')
            ->leftJoin('student_representatives', function ($join) {
                $join->on('students.id', '=','student_representatives.student_id')
                     ->where('student_representatives.state', '=', 1);
            })
            ->leftJoin('people AS representative','student_representatives.representative_id','representative.id')
            ->select(
                'representative.trade_name AS representative_trade_name',
                'representative.id AS representative_id',
                'people.trade_name AS student_trade_name',
                'people.id AS people_student_id',
                'students.id AS student_cod'
            )
            ->where('students.number_dni','=',$this->number_search)
            ->first();

        if($student){
            $this->student_cod = $student->student_cod;
            $this->student_id = $student->people_student_id;
            $this->student_name = $student->student_trade_name;
            $this->representative_id = $student->representative_id;
            $this->representative_name = $student->representative_trade_name;
        }else{
            $this->dispatchBrowserEvent('response_fail_search_student', ['message' => Lang::get('messages.no_data_available')]);
        }
    }

    public function store(){

        $this->validate([
            'docmuent_id' => 'required',
            'student_id' => 'required',
            'level_id' => 'required',
            'year_id' => 'required',
            'package_id' => 'required',
            'date_register' => 'required'
        ]);

        list($d,$m,$y) = explode('/',$this->date_register);
        $date_register = $y.'-'.$m.'-'.$d;

        $cadastre = Cadastre::create([
            'academic_level_id' => $this->level_id,
            'academic_year_id' => $this->year_id,
            'year' => Carbon::now()->year,
            'date_register' => $date_register,
            'person_id' => $this->student_id,
            'attorney_id' => $this->representative_id,
            'course_id' => $this->course_id,
            'document_id' => $this->docmuent_id,
            'observation' => $this->observation
        ]);

        Document::where('id',$this->docmuent_id)->update(['used'=>1]);

        $payments = PackageItemDetail::where('package_id',$this->package_id)
            ->orderBy('order_number')
            ->get();

        foreach($payments as $payment){
            StudentPaymentCommitments::create([
                'cadastre_id' => $cadastre->id,
                'package_id' => $this->package_id,
                'package_item_detail_id' => $payment->id,
                'student_id' => $this->student_cod,
                'person_id' => $this->student_id,
                'package_item_detail' => $payment,
                'payment_date' => $payment->date_payment
            ]);
        }
        $this->clearForm();
        $this->dispatchBrowserEvent('response_cadastre_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearForm(){
        $this->level_id = null;
        $this->year_id = null;
        $this->date_register = Carbon::now()->format('d/m/Y');
        $this->student_id = null;
        $this->representative_id = null;
        $this->docmuent_id = null;
        $this->observation = null;
        $this->representative_name = null;
        $this->docmuent_serie = null;
        $this->docmuent_number = null;
        $this->student_name = null;
        $this->number_search = null;
        $this->package_id = null;
    }
}
