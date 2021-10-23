<?php

namespace App\Http\Livewire\Dashboard\Warehouse;

use App\Models\RRHH\Payments\Expense;
use App\Models\Warehouse\Purchase;
use Livewire\Component;

class ExpensesTotal extends Component
{
    public $total;

    public function mount(){
        $this->expenses();
    }

    public function render()
    {
        return view('livewire.dashboard.warehouse.expenses-total');
    }

    public function expenses(){
        $purchases = Purchase::where('state_type_id','<>','11')
                    ->orWhere('state_type_id','<>', '13')
                    ->sum('total');
        $expenses = Expense::where('state',1)->sum('total');

        $this->total = ($purchases + $expenses);
    }
}
