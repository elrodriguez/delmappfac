<?php

namespace App\Http\Livewire\Support\Reports;

use App\Models\Master\Parameter;
use App\Models\Master\Establishment;
use App\Models\Support\Helpdesk\SupTicket;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class TicketIncidents extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishments;
    public $date_start;
    public $date_end;
    public $establishment_id;
    public $PRT007PAG;

    public function mount(){
        $this->establishments = Establishment::all();
        $this->PRT007PAG = Parameter::where('id_parameter','PRT007PAG')->value('value_default');
    }

    public function render()
    {
        return view('livewire.support.reports.ticket-incidents',['incidents' => $this->incidents()]);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function incidents(){

        return SupTicket::join('establishments','sup_tickets.establishment_id','establishments.id')
            ->join('sup_categories','sup_tickets.sup_category_id','sup_categories.id')
            ->join('sup_categories AS c2','sup_categories.sup_category_id','c2.id')
            ->join('sup_service_areas','sup_tickets.sup_service_area_id','sup_service_areas.id')
            ->where('sup_tickets.establishment_id',$this->establishment_id)
            ->whereBetween('sup_tickets.created_at', [$this->date_start, $this->date_end])
            ->select(
                'sup_tickets.created_at',
                'sup_tickets.internal_id',
                'sup_tickets.state',
                'sup_tickets.description_of_problem',
                'establishments.name',
                'sup_categories.short_description AS subcategory_description',
                'c2.short_description AS category_description',
                'sup_service_areas.description AS area_description'
            )
            ->selectSub(function($query) {
                $query->from('sup_ticket_solutions')->select(
                    DB::raw('CONCAT("[",GROUP_CONCAT(JSON_OBJECT("description",solution_description)),"]")')
                )
                ->whereColumn('sup_ticket_solutions.sup_ticket_id','sup_tickets.id');
            }, 'solutions')
            ->selectSub(function($query) {
                $query->from('sup_ticket_users')->join('users','sup_ticket_users.user_id','users.id')
                ->select(
                    'users.email'
                )
                ->whereColumn('sup_ticket_users.sup_ticket_id','sup_tickets.id')
                ->where('sup_ticket_users.type','applicant');
            }, 'user_email')
            ->selectRaw("(TIMESTAMPDIFF(MINUTE,sup_tickets.created_at,sup_tickets.updated_at)) AS time_elapsed")
            ->selectRaw("((sup_tickets.days*1440)+(sup_tickets.hours*60)+sup_tickets.minutes) AS time_limit")
            ->orderBy('sup_tickets.created_at','DESC')
            ->paginate($this->PRT007PAG);
            //dd($d);
    }
}
