<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Master\Establishment;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Master\UbigeoController;
use App\Models\Warehouse\Warehouse;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstablishmentCreateForm extends Component
{
    public $name;
    public $address;
    public $phone;
    public $observation;
    public $email;
    public $urbanization;
    public $web_page;
    public $country_id = 'PE';
    public $department_id;
    public $province_id;
    public $district_id;
    public $state = 1;
    public $ubigeo;
    public $countries = [];
    public $ubigeos = [];

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.master.establishment-create-form');
    }
    public function store()
    {

        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email'
        ]);

        if($this->ubigeo){
            list($dp,$pv,$ds) = explode('*',$this->ubigeo);
        }else{
            $dp = null;
            $pv = null;
            $ds = null;
        }

        $establishment = Establishment::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'observation' => $this->observation,
            'state' => ($this->state?$this->state:0),
            'email' => $this->email,
            'urbanization' => $this->urbanization,
            'web_page' => $this->web_page,
            'country_id' => $this->country_id,
            'department_id' => $dp,
            'province_id' => $pv,
            'district_id' => $ds
        ]);

        Warehouse::create([
            'establishment_id' => $establishment->id,
            'description' => $this->name.' - Almacen'
        ]);

        $msg = Lang::get('messages.successfully_registered');
        $user = Auth::user();

        $activity = new Activity;
        $activity->modelOn(Establishment::class,$establishment->id);
        $activity->causedBy($user);
        $activity->routeOn(route('establishments_create'));
        $activity->componentOn('master.establishment-create-form');
        $activity->dataOld($establishment);
        $activity->logType('create');
        $activity->log($msg);
        $activity->save();

        $this->resetInput();
        $this->dispatchBrowserEvent('response_establishment_store', ['message' => $msg]);
    }
    private function resetInput()
    {
        $this->name = null;
        $this->address = null;
        $this->phone = null;
        $this->observation = null;
        $this->state = false;
    }
}
