<?php

namespace App\Http\Livewire\Dashboard\Academic;

use App\Models\Academic\Administration\Teacher;
use Livewire\Component;

class TotalTeachers extends Component
{
    public $total_teachers;

    public function mount(){
        $this->total_teachers = Teacher::count();
    }

    public function render()
    {
        return view('livewire.dashboard.academic.total-teachers');
    }
}
