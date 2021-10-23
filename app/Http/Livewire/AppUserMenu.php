<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AppUserMenu extends Component
{
    protected $listeners = [
        'refresh-navigation-dropdown' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.app-user-menu');
    }
}
