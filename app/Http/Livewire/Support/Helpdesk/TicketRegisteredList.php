<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class TicketRegisteredList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $date_created;

    public function searchTicket()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-registered-list',['tickets'=>$this->tickets()]);
    }

    private function tickets(){
        $user_id_s = Auth::id();
        return SupTicket::join('sup_panic_levels','sup_tickets.sup_panic_level_id','sup_panic_levels.id')
            ->whereExists(function ($query) use ($user_id_s) {
                $query->select(DB::raw(1))
                    ->from('sup_ticket_users')
                    ->where('sup_ticket_users.user_id', $user_id_s)
                    ->where('sup_ticket_users.type','checkin')
                    ->whereColumn('sup_ticket_users.sup_ticket_id','sup_tickets.id');
            })
            ->select(
                'sup_tickets.id',
                'sup_tickets.date_application',
                'internal_id',
                'description_of_problem',
                'sup_panic_level_id',
                'sup_tickets.created_at',
                'sup_panic_levels.description',
                'sup_tickets.state'
            )
            ->selectSub(function($query) {
                $query->from('sup_ticket_users')->join('users','sup_ticket_users.user_id','users.id')
                ->leftJoin('sup_service_areas','sup_ticket_users.sup_service_area_id','sup_service_areas.id')
                ->select(
                    DB::raw('CONCAT("[",GROUP_CONCAT(JSON_OBJECT("name",users.name,"avatar",profile_photo_path,"type",sup_ticket_users.type,"incharge",sup_ticket_users.incharge,"description",sup_service_areas.description)),"]")')
                )
                ->whereColumn('sup_ticket_users.sup_ticket_id','sup_tickets.id');
            }, 'users')
            ->orderBy('sup_tickets.id','DESC')
            ->paginate(9);
    }

    public function edit($id){
        return redirect()->route('support_helpdesk_my_tickets_registered_edit',$id);
    }
}
