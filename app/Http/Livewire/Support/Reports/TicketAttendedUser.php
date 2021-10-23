<?php

namespace App\Http\Livewire\Support\Reports;

use App\Models\Master\Establishment;
use App\Models\Support\Helpdesk\SupTicketRecord;
use Livewire\Component;

class TicketAttendedUser extends Component
{
    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $users = [];

    public function mount(){
        $this->establishments = Establishment::all();
    }

    public function render()
    {
        return view('livewire.support.reports.ticket-attended-user');
    }

    public function getUsersState(){
        $this->users = SupTicketRecord::join('users','sup_ticket_records.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->select(
                'people.trade_name',
                'sup_ticket_records.state'
            )
            ->selectRaw('COUNT(user_id) AS quantity')
            ->where('sup_ticket_records.establishment_id',$this->establishment_id)
            ->whereBetween('sup_ticket_records.created_at', [$this->date_start, $this->date_end])
            ->groupBy(['people.trade_name','state','user_id'])
            ->orderBy('people.trade_name')
            ->get();
    }
}
