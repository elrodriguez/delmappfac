<?php

namespace App\Http\Livewire\Support\Reports;

use App\Models\Master\Establishment;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketRecord;
use Livewire\Component;

class StateSummaries extends Component
{
    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $states;
    public $groups = [];
    public $tickets;
    public $tickets_pending;

    public function mount(){
        $this->establishments = Establishment::all();
    }

    public function render()
    {
        return view('livewire.support.reports.state-summaries');
    }

    public function groupStates(){

        $this->validate([
            'establishment_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required'
        ]);

        $this->tickets = SupTicket::where('sup_tickets.establishment_id',$this->establishment_id)
            ->whereBetween('sup_tickets.created_at', [$this->date_start, $this->date_end])
            ->count();

        $this->tickets_pending = SupTicket::where('state','sent')
            ->where('sup_tickets.establishment_id',$this->establishment_id)
            ->whereBetween('sup_tickets.created_at', [$this->date_start, $this->date_end])
            ->count();

        $this->groups = SupTicketRecord::join('sup_service_area_groups','sup_ticket_records.from_group_id','sup_service_area_groups.id')
            ->select('sup_service_area_groups.description')
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'attended' THEN 1 END) AS attended")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'derivative' THEN 1 END) AS derivative")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'cancel' THEN 1 END) AS cancel")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'closed_ok' THEN 1 END) AS closed_ok")
            ->selectRaw("COUNT(CASE WHEN sup_ticket_records.state = 'closed_fail' THEN 1 END) AS closed_fail")
            ->groupBy('sup_service_area_groups.description')
            ->where('sup_ticket_records.establishment_id',$this->establishment_id)
            ->whereBetween('sup_ticket_records.created_at', [$this->date_start, $this->date_end])
            ->get();
    }

}
