<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\Company;
use App\Models\Master\ManagementType;
use Illuminate\Support\Facades\Lang;
use Livewire\WithFileUploads;
use Livewire\Component;

class CompanyDatas extends Component
{
    use WithFileUploads;

    public $name;
    public $trade_name;
    public $logo;
    public $management_type_id;
    public $management_types = [];

    public $company;

    public function mount(){
        $this->management_types = ManagementType::all();
        $this->company = Company::first();
        $this->name = $this->company->name;
        $this->trade_name = $this->company->tradename;
        $this->management_type_id = $this->company->id_management_type;
    }

    public function render()
    {
        return view('livewire.master.company-datas');
    }

    public function store(){

        $this->validate([
            'name' => 'required|max:255',
            'trade_name' => 'required|max:255',
            'management_type_id' => 'required'
        ]);

        if($this->logo){
            $this->validate([
                'logo' => 'image|max:1024', // 1MB Max
            ]);

            $this->logo->storeAs('company/logos/', $this->company->id.'.jpg','public');
        }

        $path_logo = 'company/logos/'.$this->company->id.'.jpg';

        $this->company->update([
            'name' => $this->name,
            'tradename' => $this->trade_name,
            'management_type_id' => $this->management_type_id,
            'logo' => $path_logo
        ]);

        $this->dispatchBrowserEvent('response_company_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

}
