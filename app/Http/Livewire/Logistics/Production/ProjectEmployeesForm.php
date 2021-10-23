<?php

namespace App\Http\Livewire\Logistics\Production;

use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectEmployees;
use App\Models\Logistics\Production\ProjectMaterial;
use App\Models\Logistics\Production\Stage;
use App\Models\RRHH\Administration\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ProjectEmployeesForm extends Component
{
    public $description;
    public $stages = [];
    public $occupations = [];
    public $project_id;
    public $project_description;
    public $person_id;
    public $stage_id = 0;
    public $occupation_id;
    public $employees = [];
    public $project;

    public $update_id;
    public $update_occupation_id;
    public $update_state;
    public $update_amount;

    public function mount($project_id){
        $this->project_id = $project_id;
        $this->project = Project::find($project_id);
        $this->project_description = $this->project->description;
    }
    public function render()
    {
        $this->stages = Stage::where('project_id',$this->project_id)->get();
        $this->occupations = DB::table('occupations')->get();
        $this->employeesList();
        return view('livewire.logistics.production.project-employees-form');
    }

    public function store($amount){
        if(count($this->stages)>0){
            $this->validate([
                'person_id' => 'required',
                'occupation_id' => 'required'
            ]);

            $employee = Employee::where('person_id',$this->person_id)->first();

            if($this->stage_id == 0){
                $stotal = count($this->stages);
                foreach($this->stages as $stage){
                    ProjectEmployees::create([
                        'person_id' => $this->person_id,
                        'employee_id' => $employee->id,
                        'salary' => ($amount/$stotal),
                        'occupation_id' => $this->occupation_id,
                        'project_id' => $this->project_id,
                        'stage_id' => $stage->id
                    ]);
                }
            }else{
                ProjectEmployees::create([
                    'person_id' => $this->person_id,
                    'employee_id' => $employee->id,
                    'salary' => $amount,
                    'occupation_id' => $this->occupation_id,
                    'project_id' => $this->project_id,
                    'stage_id' => $this->stage_id
                ]);
            }
            $this->person_id = null;
            $this->occupation_id = null;
            $this->stage_id = null;
            $this->dispatchBrowserEvent('response_projects_employees', ['message' => Lang::get('messages.successfully_registered'),'state'=>'success','title'=>Lang::get('messages.congratulations')]);
        }else{
            $this->dispatchBrowserEvent('response_projects_employees', ['message' => Lang::get('messages.the_project_must_have_at_least_one_stage'),'state'=>'error','title'=>Lang::get('messages.failed_process')]);
        }

    }

    public function employeesList(){
        $this->employees = ProjectEmployees::join('stages','project_employees.stage_id','stages.id')
                ->join('people','project_employees.person_id','people.id')
                ->join('occupations','project_employees.occupation_id','occupations.id')
                ->select(
                    'project_employees.id',
                    'people.trade_name',
                    'people.number',
                    'stages.description AS stage_description',
                    'project_employees.salary',
                    'project_employees.state',
                    'project_employees.occupation_id',
                    'occupations.description AS occupation_description'
                )
                ->where('project_employees.project_id',$this->project_id)
                ->get();
    }

    public function deleteEmployee($id){
        ProjectEmployees::where('id',$id)->delete();
    }

    public function approve(){

        $total = ProjectMaterial::where('project_id',$this->project_id)->sum('expenses');

        foreach($this->employees as $employee){
            $total = $total+$employee->salary;
        }
        if($this->project->state == 'pendiente'){
            $this->project->update([
                'state' => 'en desarrollo',
                'investment' => $total
            ]);
        }
    }

    public function update(){
        if(count($this->stages)>0){
            $this->validate([
                'update_occupation_id' => 'required',
                'update_state' => 'required',
                'update_amount' => 'required|numeric|between:0,99999999999.99'
            ]);

            ProjectEmployees::find($this->update_id)->update([
                'salary' => $this->update_amount,
                'occupation_id' => $this->update_occupation_id,
                'state' => $this->update_state
            ]);

            $total_m = ProjectMaterial::where('project_id',$this->project_id)->sum('expenses');
            $total_e = ProjectEmployees::where('project_id',$this->project_id)->sum('salary');

            $this->project->update([
                'investment' => $total_m + $total_e
            ]);

        }
    }
}
