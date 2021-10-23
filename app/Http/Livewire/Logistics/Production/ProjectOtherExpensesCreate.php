<?php

namespace App\Http\Livewire\Logistics\Production;

use App\Models\Catalogue\BankAccount;
use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectOtherExpenses;
use App\Models\Master\Person;
use App\Models\RRHH\Administration\ExpenseMethodType;
use App\Models\RRHH\Administration\ExpenseReason;
use App\Models\RRHH\Administration\ExpenseType;
use App\Models\RRHH\Payments\Expense;
use App\Models\RRHH\Payments\ExpenseItem;
use App\Models\RRHH\Payments\ExpensePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ProjectOtherExpensesCreate extends Component
{
    public $box_items = [];
    public $expense_type_id;
    public $expense_types;
    public $number;
    public $date_of_issue;
    public $expense_reasons;
    public $expense_reason_id;
    public $supplier_id;
    public $expense_payments = [];
    public $expense_method_types = [];
    public $bank_accounts = [];
    public $project_id;
    public $total = 0;
    public $description;
    public $amount;
    public $project_description;

    public function mount($project_id){
        $this->project_id = $project_id;
        $this->project = Project::find($project_id);
        $this->project_description = $this->project->description;
        $this->addPayment();
    }
    public function render()
    {
        $this->expense_types = ExpenseType::all();
        $this->expense_reasons = ExpenseReason::all();
        $this->bank_accounts = BankAccount::where('state',1)->get();
        $this->expense_method_types = ExpenseMethodType::leftJoin('card_brands','expense_method_types.card_brand_id','card_brands.id')
            ->select(
                'expense_method_types.id',
                'expense_method_types.has_card',
                DB::raw('IF(expense_method_types.has_card=1,CONCAT(card_brands.description," - ",expense_method_types.description),expense_method_types.description) AS description'),
                'expense_method_types.card_brand_id'
            )->get();

        return view('livewire.logistics.production.project-other-expenses-create');
    }

    public function addPayment(){
        array_push(
            $this->expense_payments,
            array(
                'expense_id' => null,
                'date_of_payment' => Carbon::now()->format('Y-m-d'),
                'expense_method_type_id' => 1,
                'has_card' => 0,
                'card_brand_id' => null,
                'reference' => null,
                'payment' => null,
                'bank_account_id' => null
            )
        );
    }

    public function addDetails(){
        $this->validate([
            'description' => 'required',
            'amount' => 'required|numeric|between:0,99999999999.99'
        ]);

        $data = [
            'description' => $this->description,
            'total' => $this->amount
        ];

        array_push($this->box_items,$data);
        $this->total = number_format(($this->total+$this->amount), 2, '.', '');

        $this->description = null;
        $this->amount = null;

        $this->updatePayment();
    }

    public function removePayment($index){
        unset($this->expense_payments[$index]);
    }

    public function removeDetail($index){
        $item = $this->box_items[$index];
        $this->total = number_format(($this->total-$item['total']), 2, '.', '');
        unset($this->box_items[$index]);
        $this->updatePayment();
    }

    protected function updatePayment(){
        $this->expense_payments[0] =[
            'expense_id' => null,
            'date_of_payment' => Carbon::now()->format('Y-m-d'),
            'expense_method_type_id' => 1,
            'has_card' => 0,
            'card_brand_id' => null,
            'reference' => null,
            'payment' => $this->total,
            'bank_account_id' => null
        ];
    }
    public function store(){
        $this->validate([
            'expense_type_id' => 'required',
            'expense_reason_id' => 'required',
            'number' => 'required|numeric',
            'date_of_issue' => 'required',
            'supplier_id' => 'required',
        ]);

        if(count($this->expense_payments)>0){
            foreach($this->expense_payments as $k => $item){
                $this->validate([
                    'expense_payments.'.$k.'.payment' => 'required|numeric|between:0,99999999999.99'
                ]);
            }
        }else{
            $this->dispatchBrowserEvent('response_success_expenses_store', ['message' => 'Agregar minimo un pago','title'=>'Falta','icon'=>'info']);
        }
        if(count($this->box_items)>0){
            foreach($this->box_items as $k => $item){
                $this->validate([
                    'box_items.'.$k.'.description' => 'required|max:255',
                    'box_items.'.$k.'.total' => 'required|numeric|between:0,99999999999.99'
                ]);
            }
        }else{
            $this->dispatchBrowserEvent('response_success_expenses_store', ['message' => 'Agregar detalles a la bandeja','title'=>'Falta','icon'=>'info']);
        }

        if(count($this->expense_payments)>0 &&  count($this->box_items)>0){

            $external_id = uuids();
            $time_of_issue = date('H:i:s');
            list($d,$m,$y) = explode('/',$this->date_of_issue);
            $date_of_issue = $y.'-'.$m.'-'.$d;

            $supplier = Person::join('suppliers','suppliers.person_id','people.id')
                        ->where('suppliers.id',$this->supplier_id)
                        ->select('people.*')
                        ->first();

            $expense = Expense::create([
                'user_id' => Auth::id(),
                'expense_type_id' => $this->expense_type_id,
                'establishment_id' => Auth::user()->establishment_id,
                'person_id' => Auth::user()->person_id,
                'currency_type_id' => 'PEN',
                'external_id' => $external_id,
                'number' => $this->number,
                'date_of_issue' => $date_of_issue,
                'time_of_issue' => $time_of_issue,
                'supplier' => $supplier,
                'exchange_rate_sale' => 0,
                'total' => $this->total,
                'state' => 1,
                'expense_reason_id' => $this->expense_reason_id
            ]);

            foreach($this->expense_payments as $k => $item){
                ExpensePayment::create([
                    'expense_id' => $expense->id,
                    'date_of_payment' => $item['date_of_payment'],
                    'expense_method_type_id' => $item['expense_method_type_id'],
                    'has_card' => $item['has_card'],
                    'card_brand_id' => $item['card_brand_id'],
                    'reference'  => $item['reference'],
                    'payment' => $item['payment'],
                    'bank_account_id' => ($item['bank_account_id'] == 0?null:$item['bank_account_id'])
                ]);
            }

            foreach($this->box_items as $k => $item){
                ExpenseItem::create([
                    'expense_id' => $expense->id,
                    'description' => $item['description'],
                    'total' => $item['total']
                ]);
            }

            ProjectOtherExpenses::create([
                'expense_id' => $expense->id,
                'project_id' => $this->project_id
            ]);

            $this->clearForm();
            $this->dispatchBrowserEvent('response_success_expenses_store', ['message' => Lang::get('messages.successfully_registered'),'title'=>Lang::get('messages.congratulations'),'icon'=>'success']);
        }

    }

    private function clearForm(){
        $this->expense_payments = [];

        $this->box_items = [];
        $this->expense_reason_id = null;
        $this->expense_type_id = null;
        $this->expense_types = null;
        $this->number = null;
        $this->date_of_issue = Carbon::now()->format('d/m/Y');
        $this->total = 0;

        $this->addPayment();

    }
}
