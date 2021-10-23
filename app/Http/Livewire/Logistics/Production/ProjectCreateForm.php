<?php

namespace App\Http\Livewire\Logistics\Production;
use App\Http\Controllers\Master\UbigeoController;
use App\Models\Logistics\Production\Project;
use App\Models\Master\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

use Livewire\Component;

class ProjectCreateForm extends Component
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
    public $customer_id;
    public $person_customer_id;

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.logistics.production.project-create-form');
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
        $customer = Customer::find($this->person_customer_id);
        Project::create([
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
            'type' => 'project',
            'customer_id' => $this->person_customer_id,
            'person_customer_id' => $customer->person_id
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('response_projects_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function resetInput(){
        $this->responsable_id = null;
        $this->description = null;
        $this->ubigeo = null;
        $this->country_id = 'PE';
        $this->budget = null;
        $this->date_start = null;
        $this->date_end = null;
        $this->address = null;
        $this->person_customer_id = null;
    }
}
