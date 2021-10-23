<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketSolution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class TicketAttendSuggestList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ticket_id;
    public $ticket;

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);
        $this->ticket = SupTicket::find($this->ticket_id);
    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-attend-suggest-list',['recommended'=>$this->getRecommended()]);
    }

    public function getRecommended(){
        return SupTicketSolution::join('sup_tickets','sup_ticket_solutions.sup_ticket_id','sup_tickets.id')
            ->where('sup_ticket_solutions.sup_category_id',$this->ticket->sup_category_id)
            ->select(
                'sup_ticket_solutions.id',
                'sup_tickets.internal_id',
                'sup_ticket_solutions.sup_ticket_id',
                'sup_ticket_solutions.solution_description',
                'sup_ticket_solutions.points'
            )
            ->selectSub(function($query) {
                $query->from('sup_ticket_files')
                ->select(
                    DB::raw('CONCAT("[",GROUP_CONCAT(JSON_OBJECT("name",original_name,"url",url)),"]")')
                )
                ->where('sup_ticket_files.sup_table_type',SupTicketSolution::class)
                ->whereColumn('sup_ticket_files.sup_table_id','sup_ticket_solutions.id');
            }, 'files_olds')
            ->orderBy('points','DESC')
            ->orderBy('sup_ticket_id')
            ->paginate(10);
    }

    public function points($id){

        $SupTicketSolution = SupTicketSolution::where('id',$id)->where(function($query){
            $query->whereNull('user_id_like')
                ->orWhere('user_id_like','<>',Auth::id());
        });

        if($SupTicketSolution){
            $SupTicketSolution->update([
                'user_id_like' => Auth::id(),
                'points' => DB::raw('points + 1')
            ]);
        }
    }
}
