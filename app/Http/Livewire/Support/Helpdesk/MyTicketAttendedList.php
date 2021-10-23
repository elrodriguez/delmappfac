<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Master\Parameter;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Administration\SupServiceAreaUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class MyTicketAttendedList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $date_created;
    public $perspective = 'table';
    public $PRT007PAG;

    public function mount(){
        $this->PRT007PAG = Parameter::where('id_parameter','PRT007PAG')->value('value_default');
    }
    public function render()
    {
        return view('livewire.support.helpdesk.my-ticket-attended-list',['tickets'=>$this->tickets()]);
    }

    public function changeView($type){
        $this->perspective = $type;
    }

    public function tickets(){
        $search = $this->search;
        $user_id_s = Auth::id();

        $user_area = SupServiceAreaUser::where('user_id',$user_id_s)->first();
        $group_id = $user_area->sup_service_area_group_id;

        return SupTicket::join('sup_panic_levels','sup_tickets.sup_panic_level_id','sup_panic_levels.id')
            ->whereExists(function ($query) use ($user_id_s) {
                $query->select(DB::raw(1))
                  ->from('sup_ticket_users')
                  ->where('sup_ticket_users.user_id', $user_id_s)
                  //->where('sup_ticket_users.type','technical')
                  ->whereColumn('sup_ticket_users.sup_ticket_id','sup_tickets.id');
        })
        //->where('sup_service_area_id',$user_area->sup_service_area_id)
        //->when($group_id, function ($query, $group_id) {
        //    return $query->where('sup_service_area_group_id', $group_id);
        //})
        ->when($search, function ($query, $search) {
            return $query->where('internal_id', $search);
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
        ->orderBy('sup_tickets.id','DESC')
        ->paginate($this->PRT007PAG);
    }

    public function searchTicket()
    {
        $this->resetPage();
    }

    public function seeDetails($id){

        return redirect()->route('support_helpdesk_my_ticket_attended_see',myencrypt($id));
    }
}
