<?php

namespace App\Http\Livewire\Dashboard\Academic;

use App\Models\Academic\Administration\Student;
use Livewire\Component;

class TotalStudent extends Component
{
    public $total_student;

    public function mount(){
        $this->total_student = Student::count();
    }

    public function render()
    {
        return view('livewire.dashboard.academic.total-student');
    }

}
