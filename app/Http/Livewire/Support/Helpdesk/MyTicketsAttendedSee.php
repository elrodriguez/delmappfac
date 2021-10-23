<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\Support\Helpdesk\SupTicket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTicketsAttendedSee extends Component
{
    public $ticket_id;
    public $ticket;
    public $user;
    public $states_not = array('sent','attended');

    public function mount($ticket_id){
        $this->ticket_id = $ticket_id;
    }

    public function render()
    {
        $this->ticket = SupTicket::find(mydecrypt($this->ticket_id));
        $this->user = SupServiceAreaUser::where('user_id',Auth::id())->first();
        return view('livewire.support.helpdesk.my-tickets-attended-see');
    }
}
