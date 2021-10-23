<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicketSolution;
use Livewire\Component;

class TicketAttendSolutions extends Component
{
    public $ticket_id;
    public $solutions;

    public function mount($ticket_id){

        $this->ticket_id = mydecrypt($ticket_id);

        $this->solutions = SupTicketSolution::where('sup_ticket_id',$this->ticket_id)
            ->get();
    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-attend-solutions');
    }
}
