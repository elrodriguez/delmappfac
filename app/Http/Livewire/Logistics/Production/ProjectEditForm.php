<?php

namespace App\Http\Livewire\Logistics\Production;

use App\Http\Controllers\Master\UbigeoController;
use App\Models\Logistics\Production\Project;
use App\Models\Master\Customer;
use App\Models\Master\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Arr;
use Livewire\Component;

class ProjectEditForm extends Component
{
    public $responsable_id;
    public $description;
    public $countries = [];
    public $ubigeos = [];
    public $ubigeo = null;
    public $country_id = 'PE';
    public $budget;
    public $total_expenses = 0;
    public $date_start;
    public $date_end;
    public $address;
    public $project_id;
    public $responsable_name;
    public $dates;
    public $states = [];
    public $state_id;
    public $customer_id;
    public $person_customer_id;
    public $customer_name;

    public function mount($project_id){
        $this->project_id = $project_id;
        $project = Project::find($project_id);
        $this->responsable_name = Person::find($project->person_id)->trade_name;

        if($project->person_customer_id){
            $this->customer_name = Person::find($project->person_customer_id)->trade_name;
        }

        $this->responsable_id = $project->person_id;
        $this->description = $project->description;
        $this->ubigeo = $project->department_id.'*'.$project->province_id.'*'.$project->district_id;
        $this->country_id = $project->country_id;
        $this->budget = $project->budget;
        $this->date_start = $project->date_start;
        $this->date_end = $project->date_end;
        $this->address = $project->address;
        $this->state_id = $project->state;
        $this->total_expenses = ceil($project->investment);
        $this->person_customer_id = $project->person_customer_id;

        if($project->date_start){
            $this->dates = Carbon::parse($project->date_start)->format('d/m/Y').' - '.Carbon::parse($project->date_end)->format('d/m/Y');
        }

    }
    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        $this->getStateProject();
        return view('livewire.logistics.production.project-edit-form');
    }
    public function store(){
        $this->validate([
            'description' => 'required',
            'country_id' => 'required',
            'ubigeo' => 'required',
            'address' => 'required',
            'person_customer_id' => 'required'
        ]);
        if($this->ubigeo){
            list($dp,$pv,$ds) = explode('*',$this->ubigeo);
        }else{
            $dp = null;
            $pv = null;
            $ds = null;
        }

        $customer = Customer::where('person_id',$this->person_customer_id)->first();

        Project::where('id',$this->project_id)->update([
            'description' => $this->description,
            'person_id' => $this->responsable_id,
            'country_id' => $this->country_id,
            'department_id' => $dp,
            'province_id' => $pv,
            'district_id' => $ds,
            'address' => $this->address,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'budget' => $this->budget,
            'investment' => $this->total_expenses,
            'state' => $this->state_id,
            'customer_id' => $customer->id,
            'person_customer_id' => $this->person_customer_id
        ]);

        $this->dispatchBrowserEvent('response_projects_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }

    private function getStateProject(){
        $type = DB::select( DB::raw("SHOW COLUMNS FROM projects WHERE FIELD = 'state'") )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $enum = Arr::add($enum, $v, $v);
        }
       $this->states = $enum;
    }
}
