<?php

namespace App\Http\Livewire\Onlineshop\Client;

use App\Models\Master\Company;
use App\Models\Master\SocialMedia;
use Livewire\Component;

class UpperHeaderSection extends Component
{
    public $social_media;
    public $company;

    public function mount(){
        $this->social_media = SocialMedia::all();
        $this->company = Company::first();
    }

    public function render()
    {
        return view('livewire.onlineshop.client.upper-header-section');
    }
}
