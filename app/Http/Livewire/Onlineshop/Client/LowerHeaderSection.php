<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\Master\Company;
use App\Models\OnlineShop\ShoConfiguration;
use Livewire\Component;

class LowerHeaderSection extends Component
{
    public $configuration;
    public $company;

    public function mount(){
        $this->configuration = ShoConfiguration::first();
        $this->company = Company::first();
    }
    public function render()
    {
        return view('livewire.onlineshop.client.lower-header-section');
    }
}
