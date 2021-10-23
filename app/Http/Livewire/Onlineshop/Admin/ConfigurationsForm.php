<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoConfiguration;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigurationsForm extends Component
{
    public $configuration;
    public $fixed_phone;
    public $mobile_phone;
    public $logo;
    public $logo_view;
    public $email;
    public $address;
    public $map;
    public $discount;
    public $configuration_id;

    use WithFileUploads;

    public function render()
    {
        $this->configuration = ShoConfiguration::first();

        if($this->configuration){
            $this->configuration_id = $this->configuration->id;
            $this->fixed_phone = $this->configuration->fixed_phone;
            $this->mobile_phone = $this->configuration->mobile_phone;
            $this->email = $this->configuration->email;
            $this->address = $this->configuration->address;
            $this->map = $this->configuration->map;
            $this->discount = $this->configuration->discount;
            if($this->configuration->logo){
                $this->logo_view = $this->configuration->logo;
            }
        }
        
        
        return view('livewire.onlineshop.admin.configurations-form');
    }

    public function save(){

        $this->validate([
            'fixed_phone' => 'required',
            'mobile_phone' => 'required',
            'email' => 'required',
            'address' => 'required'
            ///'logo' => 'image|max:10240', // 1MB Max
        ]);

        $nfile = null;

        $data = [
            'fixed_phone' => $this->fixed_phone,
            'mobile_phone'  => $this->mobile_phone,
            'email' => $this->email,
            'map'  => $this->map,
            'address' => $this->address,
            'discount' => $this->discount?1:0
        ];

        if($this->logo){
            $name = date('YmdHis').'.png';
            $nfile = 'company'.DIRECTORY_SEPARATOR.'logos'.DIRECTORY_SEPARATOR.$name;
            $this->logo->storeAs('company'.DIRECTORY_SEPARATOR.'logos'.DIRECTORY_SEPARATOR,$name,'public');
            $data['logo'] = $nfile;
        }

        if($this->configuration_id){
            ShoConfiguration::where('id',$this->configuration_id)
                ->update($data);
            $this->dispatchBrowserEvent('response_configurations_save', ['message' => Lang::get('messages.was_successfully_updated')]);
        }else{
            ShoConfiguration::create($data);
            $this->dispatchBrowserEvent('response_configurations_save', ['message' => Lang::get('messages.successfully_registered')]);
        }
    }
}
