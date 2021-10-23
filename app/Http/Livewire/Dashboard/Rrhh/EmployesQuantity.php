<?php

namespace App\Http\Livewire\Dashboard\Rrhh;

use App\Models\RRHH\Administration\Employee;
use Livewire\Component;

class EmployesQuantity extends Component
{
    public $total;

    public function mount(){
        $this->getEmployesQuantity();
    }

    public function render()
    {
        return view('livewire.dashboard.rrhh.employes-quantity');
    }
    public function getEmployesQuantity(){
        $this->total = Employee::count();
    }
}
