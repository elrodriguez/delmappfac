<?php

namespace App\Http\Livewire\Dashboard\Academic;

use App\Models\User;
use Livewire\Component;

class TotalUsers extends Component
{
    public $total_users;

    public function mount(){
        $this->total_users = User::count();
    }

    public function render()
    {
        return view('livewire.dashboard.academic.total-users');
    }
}
