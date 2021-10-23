<?php

namespace App\Http\Livewire\Support\Reports;

use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketRecord;
use App\Models\Support\Helpdesk\SupTicketChat;
use Livewire\Component;

class TicketTimeline extends Component
{
    public $ticket_id;
    public $ticket_start = [];
    public $records = [];
    public $chats = [];

    public function render()
    {
        return view('livewire.support.reports.ticket-timeline');
    }

    public function searchTicket(){
        $this->ticket_start = SupTicket::join('sup_ticket_users','sup_tickets.id','sup_ticket_users.sup_ticket_id')
            ->join('users','sup_ticket_users.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->select(
                'sup_tickets.id',
                'sup_tickets.internal_id',
                'sup_tickets.date_application',
                'sup_tickets.description_of_problem',
                'people.trade_name'
            )
            ->where('sup_tickets.internal_id',$this->ticket_id)
            ->where('sup_ticket_users.type','applicant')
            ->first();

        $this->records = SupTicketRecord::where('sup_ticket_id',$this->ticket_start->id)
            ->join('users','sup_ticket_records.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->join('sup_service_area_groups','sup_ticket_records.from_group_id','sup_service_area_groups.id')
            ->join('sup_service_areas','sup_ticket_records.from_area_id','sup_service_areas.id')
            ->select(
                'sup_ticket_records.description',
                'sup_ticket_records.created_at',
                'sup_ticket_records.state',
                'people.trade_name',
                'sup_service_area_groups.description AS group_description',
                'sup_service_areas.description AS area_description'
            )
            ->orderBy('sup_ticket_records.created_at')
            ->get();

        $this->chats = SupTicketChat::join('users','sup_ticket_chats.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->where('sup_ticket_id',$this->ticket_start->id)
            ->select(
                'people.trade_name',
                'users.profile_photo_path',
                'sup_ticket_chats.created_at',
                'sup_ticket_chats.message'
            )
            ->orderBy('sup_ticket_chats.created_at')
            ->get();
    }

}
