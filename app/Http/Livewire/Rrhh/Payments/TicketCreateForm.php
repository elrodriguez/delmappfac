<?php

namespace App\Http\Livewire\Rrhh\Payments;

use App\Models\Logistics\Production\ProjectEmployees;
use App\Models\Logistics\Production\ProjectOtherExpenses;
use App\Models\Master\Person;
use App\Models\RRHH\Administration\Employee;
use App\Models\RRHH\Payments\EmployeeConcept;
use App\Models\RRHH\Payments\Expense;
use App\Models\RRHH\Payments\ExpenseItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class TicketCreateForm extends Component
{
    public $person_id;
    public $employee_id;
    public $employee_concepts = [];
    public $employee_projects = [];
    public $box_items = [];
    public $total = 0;
    public $external_id;

    public function render()
    {
        return view('livewire.rrhh.payments.ticket-create-form');
    }

    public function searchEmployeeConcepts(){
        $employee = Employee::where('person_id',$this->person_id)->first();
        if($employee){
            $this->employee_id = $employee->id;
        }

        $employee_concepts = EmployeeConcept::join('concepts','employee_concepts.concept_id','concepts.id')
                    ->select(
                        'employee_concepts.id',
                        'concepts.description',
                        'concepts.operation',
                        'employee_concepts.observations',
                        'employee_concepts.amount',
                        'employee_concepts.created_at'
                    )
                    ->where('person_id',$this->person_id)
                    ->where('state',0)
                    //->where('concept_id','<>',4)
                    ->orderBy('employee_concepts.created_at')
                    ->get();
        foreach($employee_concepts as $key => $employee_concept){
            $this->employee_concepts[$key] = [
                'id' => $employee_concept->id,
                'description' => $employee_concept->description,
                'operation' => $employee_concept->operation,
                'observations' => $employee_concept->observations,
                'amount' => $employee_concept->amount,
                'created_at' => $employee_concept->created_at
            ];
        }

        $employee_projects = ProjectEmployees::join('stages', function ($join) {
                        $join->on('project_employees.stage_id', '=', 'stages.id')
                                ->on('project_employees.project_id','=','stages.project_id');
                    })
                    ->join('projects','project_employees.project_id','projects.id')
                    ->select(
                        'project_employees.id',
                        'projects.description AS pro_name',
                        'stages.description',
                        'project_employees.salary',
                        'project_employees.created_at'
                    )
                    ->where('project_employees.person_id',$this->person_id)
                    ->where('project_employees.paid',0)
                    ->where('project_employees.state',1)
                    ->orderBy('project_employees.created_at')
                    ->get();
        foreach($employee_projects as $key => $employee_project){
            $this->employee_projects[$key] = [
                'id' => $employee_project->id,
                'pro_name' => $employee_project->pro_name,
                'description' => $employee_project->description,
                'salary' => $employee_project->salary,
                'created_at' => $employee_project->created_at
            ];
        }
    }

    public function selectConceptItem($index){
        $item = $this->employee_concepts[$index];

        $key = array_search($item['id'], array_column($this->box_items, 'concept_id'));

        if($key === false){
            $new_amount = ($item['operation']==0?-$item['amount']:$item['amount']);
            array_push($this->box_items,[
                'concept_id' => $item['id'],
                'description' => $item['description'],
                'total' => $new_amount,
                'proj_emp_id' => null
            ]);

            $this->total = number_format(($this->total + $new_amount), 2, '.', '');
        }
    }

    public function selectProjectEmployee($index){
        $item = $this->employee_projects[$index];

        $key = array_search($item['id'], array_column($this->box_items, 'proj_emp_id'));

        if($key === false){
            array_push($this->box_items,[
                'concept_id' => 3,
                'description' => $item['description'],
                'total' => $item['salary'],
                'proj_emp_id' => $item['id']
            ]);

            $this->total = number_format(($this->total + $item['salary']), 2, '.', '');
        }
    }

    public function removeItem($key){
        $item = $this->box_items[$key];
        $this->total = number_format(($this->total-$item['total']), 2, '.', '');
        unset($this->box_items[$key]);
    }

    public function store(){
        if($this->total > 0){
            $this->validate([
                'person_id' => 'required'
            ]);

            $this->external_id = uuids();
            $maxid = Expense::where('employee_pay',true)->max('number');
            $person = Person::find($this->person_id);

            $expense = Expense::create([
                'user_id' => Auth::id(),
                'expense_type_id' => 4,
                'establishment_id' => 1,
                'person_id' => $this->person_id,
                'currency_type_id' => 'PEN',
                'external_id' => $this->external_id,
                'number' => (($maxid?$maxid:0)+1),
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'time_of_issue' => Carbon::now()->format('H:i:s'),
                'supplier' => json_encode($person),
                'exchange_rate_sale' => 0,
                'total' => $this->total,
                'expense_reason_id' => 1,
                'employee_pay' => true
            ]);

            foreach($this->box_items as $item){
                ExpenseItem::create([
                    'expense_id' => $expense->id,
                    'concept_id' => $item['concept_id'],
                    'description' => $item['description'],
                    'total' => $item['total'],
                    'proj_emp_id' => $item['proj_emp_id']
                ]);

                $projectemployees = ProjectEmployees::where('id',$item['proj_emp_id'])->first();

                if($projectemployees){

                    $projectemployees->update(
                        ['paid'=>1]
                    );

                    ProjectOtherExpenses::create([
                        'project_id' => $projectemployees->project_id,
                        'expense_id' => $expense->id
                    ]);
                }

                EmployeeConcept::where('id',$item['concept_id'])->update([
                    'state' => 1,
                    'payment_date' => Carbon::now()->format('Y-m-d')
                ]);
            }
            $this->person_id = null;
            $this->box_items = [];
            $this->employee_projects = [];
            $this->employee_concepts = [];

            $this->dispatchBrowserEvent('response_success_tecket_employee', ['message' => Lang::get('messages.successfully_registered')]);
        }
    }
}
