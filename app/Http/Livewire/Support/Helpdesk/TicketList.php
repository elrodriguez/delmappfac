<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Master\Parameter;
use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketRecord;
use App\Models\Support\Helpdesk\SupTicketUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class TicketList extends Component
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

    public function changeView($type){
        $this->perspective = $type;
    }

    public function searchTicket()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-list',['tickets'=>$this->tickets()]);
    }

    private function tickets(){


        $user_area = SupServiceAreaUser::where('user_id',Auth::id())->first();
        $group_id = null;
        $search = $this->search;

        if($user_area){
            $group_id = $user_area->sup_service_area_group_id;
        }

        return SupTicket::join('sup_panic_levels','sup_tickets.sup_panic_level_id','sup_panic_levels.id')
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
        ->where('sup_tickets.sup_service_area_id', $user_area->sup_service_area_id)
        ->when($group_id, function ($query, $group_id) {
            return $query->whereRaw('IF(sup_service_area_group_id is null,true,sup_service_area_group_id = ? )', [$group_id]);
        })
        ->when($search, function ($query, $search) {
            return $query->where('sup_tickets.internal_id',$search);
        })
        ->orderBy('sup_tickets.id','DESC')
        ->paginate($this->PRT007PAG);
    }

    public function attended($id){
        $ticket = SupTicket::find($id);

        if($ticket->state = 'sent'){

            SupTicketUser::where('sup_ticket_id',$ticket->id)
                ->update(['incharge'=>false]);

            $area_user = SupServiceAreaUser::where('user_id',Auth::id())->select('sup_service_area_id','sup_service_area_group_id')->first();

            $exists = SupTicketUser::where('sup_ticket_id',$ticket->id)
                ->where('user_id',Auth::id())
                ->exists();

            if(!$exists){
                SupTicketUser::create([
                    'sup_ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'type' => 'technical',
                    'incharge' => true,
                    'sup_service_area_id' => $area_user->sup_service_area_id
                ]);
            }

            $exists_record = SupTicketRecord::where('sup_ticket_id',$ticket->id)
                ->where('from_group_id',$area_user->sup_service_area_group_id)
                ->where('state','attended')
                ->exists();
            if(!$exists_record){
                SupTicketRecord::create([
                    'sup_ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'from_area_id' => $area_user->sup_service_area_id,
                    'from_group_id' => $area_user->sup_service_area_group_id,
                    'state' => 'attended',
                    'establishment_id' => $ticket->establishment_id
                ]);
            }

            $ticket->update([
                'state' => 'attended',
                'date_attended' => Carbon::now()->format('Y-m-d')
                //'sup_service_area_id' => $level_id
            ]);

        }

        return redirect()->route('support_helpdesk_ticket_attend',myencrypt($ticket->id));
    }

}
