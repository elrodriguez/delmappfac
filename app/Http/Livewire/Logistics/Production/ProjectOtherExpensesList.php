<?php

namespace App\Http\Livewire\Logistics\Production;

use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectOtherExpenses;
use App\Models\RRHH\Payments\Expense;
use App\Models\RRHH\Payments\ExpenseItem;
use App\Models\RRHH\Payments\ExpensePayment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProjectOtherExpensesList extends Component
{
    public $otherexpenses = [];
    public $project_id;
    public $project_description;
    public $items = [];
    public $payments = [];
    public $modalTitle;
    public $total_details;

    public function mount($project_id){
        $this->project_id = $project_id;
        $this->project = Project::find($project_id);
        $this->project_description = $this->project->description;
    }

    public function render()
    {
        $this->otherexpenses = ProjectOtherExpenses::join('expenses','project_other_expenses.expense_id','expenses.id')
            ->join('expense_reasons','expenses.expense_reason_id','expense_reasons.id')
            ->join('expense_types','expenses.expense_type_id','expense_types.id')
            ->where('project_other_expenses.project_id',$this->project_id)
            ->select(
                'expenses.id',
                'expenses.external_id',
                'expenses.number',
                'expenses.supplier',
                'expenses.total',
                'expenses.state',
                'expenses.date_of_issue',
                'expense_reasons.description AS reason_description',
                'expense_types.description AS type_description'
            )
            ->get();
        return view('livewire.logistics.production.project-other-expenses-list');
    }

    public function expensesCancel($expense_id){
        Expense::find($expense_id)->update(['state'=>0]);
    }
    public function expensesRestore($expense_id){
        Expense::find($expense_id)->update(['state'=>1]);
    }

    public function openModalExpenses($expense_id,$type,$total){
        $this->total_details = $total;
        if($type == 'items'){
            $this->items = ExpenseItem::where('expense_id',$expense_id)
                ->select('description','total')
                ->get();
                $this->payments = [];
                $this->modalTitle = 'Descripcion de Gastos';
        }else{
            $this->payments = ExpensePayment::join('expense_method_types','expense_payments.expense_method_type_id','expense_method_types.id')
                ->leftJoin('bank_accounts','expense_payments.bank_account_id','bank_accounts.id')
                ->leftJoin('card_brands','expense_payments.card_brand_id','card_brands.id')
                ->where('expense_id',$expense_id)
                ->select(
                    'expense_payments.date_of_payment',
                    'expense_payments.reference',
                    'expense_payments.payment',
                    'expense_method_types.description',
                    'expense_payments.has_card',
                    DB::raw('CONCAT(bank_accounts.description," - ",bank_accounts.number) AS bank_account_description'),
                    DB::raw('CONCAT(card_brands.description," - ") AS card_brand_description')
                )
                ->get();
                $this->items = [];
                $this->modalTitle = 'Detalle de Pagos';
        }
        $this->dispatchBrowserEvent('response_modal_expenses_details', ['message' => true]);
    }
}
