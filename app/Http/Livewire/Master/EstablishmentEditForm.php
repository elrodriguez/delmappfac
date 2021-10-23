<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\Master\Establishment;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Master\UbigeoController;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstablishmentEditForm extends Component
{
    public $id_establishment;
    public $name;
    public $address;
    public $phone;
    public $observation;
    public $email;
    public $urbanization;
    public $web_page;
    public $country_id;
    public $department_id;
    public $province_id;
    public $district_id;
    public $state = 1;
    public $ubigeo;
    public $countries = [];
    public $ubigeos = [];

    public function mount($id_establishment){
        $establishment = Establishment::find($id_establishment);
        $this->id_establishment = $establishment->id;
        $this->name = $establishment->name;
        $this->address = $establishment->address;
        $this->phone = $establishment->phone;
        $this->observation = $establishment->observation;
        $this->email = $establishment->email;
        $this->urbanization = $establishment->urbanization;
        $this->web_page = $establishment->web_page;
        $this->country_id = $establishment->country_id;
        $this->department_id = $establishment->department_id;
        $this->province_id = $establishment->province_id;
        $this->district_id = $establishment->district_id;
        $this->state = $establishment->state;

        if($establishment->department_id && $establishment->province_id && $establishment->district_id){
            $this->ubigeo = $establishment->department_id.'*'.$establishment->province_id.'*'.$establishment->district_id;
        }

    }

    public function render()
    {
        $this->countries = DB::table('countries')->where('active',1)->get();
        $ubigeos = new UbigeoController;
        $this->ubigeos = $ubigeos->ubigeo();
        return view('livewire.master.establishment-edit-form');
    }
    public function update()
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


        $activity = new Activity;

        $establishment_old = Establishment::find($this->id_establishment);

        $activity->dataOld($establishment_old);

        Establishment::find($this->id_establishment)->update([
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

        $msg = Lang::get('messages.was_successfully_updated');
        $user = Auth::user();


        $activity->modelOn(Establishment::class,$this->id_establishment);
        $activity->causedBy($user);
        $activity->routeOn(route('establishments_edit'));
        $activity->componentOn('master.establishment-edit-form');
        $activity->dataUpdated(Establishment::find($this->id_establishment));
        $activity->logType('update');
        $activity->log($msg);
        $activity->save();

        $this->dispatchBrowserEvent('response_establishment_store', ['message' => $msg]);
    }
}
