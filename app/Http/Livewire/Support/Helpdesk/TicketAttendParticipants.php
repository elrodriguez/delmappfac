<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicketUser;
use Livewire\Component;

class TicketAttendParticipants extends Component
{
    public $participants;
    public $ticket_id;

    public function mount($ticket_id){

        $this->ticket_id = mydecrypt($ticket_id);

        $this->participants = SupTicketUser::join('users','sup_ticket_users.user_id','users.id')
            ->leftJoin('sup_service_areas','sup_ticket_users.sup_service_area_id','sup_service_areas.id')
            ->select(
                'users.name',
                'users.profile_photo_path',
                'sup_ticket_users.type',
                'sup_ticket_users.incharge',
                'sup_service_areas.description'
            )
            ->where('sup_ticket_users.sup_ticket_id',$this->ticket_id)
            ->get();
    }
    public function render()
    {
        return view('livewire.support.helpdesk.ticket-attend-participants');
    }
}
