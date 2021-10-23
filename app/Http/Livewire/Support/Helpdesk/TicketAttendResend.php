<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Administration\SupServiceArea;
use App\Models\Support\Helpdesk\SupTicket;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use App\Models\Support\Helpdesk\SupTicketUser;
use App\Models\Support\Administration\SupServiceAreaGroup;
use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\Support\Helpdesk\SupTicketRecord;
use Livewire\Component;

class TicketAttendResend extends Component
{
    public $user_id_add;
    public $ticket_id;
    public $sup_service_area_id;
    public $sup_service_area_group_id;
    public $areas;
    public $ticket;
    public $groups = [];
    public $description;

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);
        $this->ticket = SupTicket::where('id',$this->ticket_id)->first();
    }

    public function loadGroup(){
        $this->groups = SupServiceAreaGroup::where('state',1)
            ->where('sup_service_area_id',$this->sup_service_area_id)
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->areas = SupServiceArea::where('state',1)->get()->toArray();

        return view('livewire.support.helpdesk.ticket-attend-resend');
    }

    public function store(){

        $this->validate([
            'sup_service_area_id' => 'required',
            'sup_service_area_group_id' => 'required',
            'description' => 'required'
        ]);

        $this->ticket->update([
            'state' => 'derivative',
            'sup_service_area_id' => $this->sup_service_area_id,
            'sup_service_area_group_id' => $this->sup_service_area_group_id,
            'derivation_return_description' => $this->description
        ]);

        $area_user = SupServiceAreaUser::where('user_id',Auth::id())->select('sup_service_area_id','sup_service_area_group_id')->first();

        $exists_record = SupTicketRecord::where('sup_ticket_id',$this->ticket->id)
                ->where('from_group_id',$area_user->sup_service_area_group_id)
                ->where('state','derivative')
                ->where('to_group_id',$this->sup_service_area_group_id)
                ->exists();
        if(!$exists_record){
            SupTicketRecord::create([
                'sup_ticket_id' => $this->ticket_id,
                'user_id' => Auth::id(),
                'from_area_id' => $area_user->sup_service_area_id,
                'from_group_id' => $area_user->sup_service_area_group_id,
                'to_area_id' => $this->sup_service_area_id,
                'to_group_id' => $this->sup_service_area_group_id,
                'description' => $this->description,
                'state' => 'derivative',
                'establishment_id' => $this->ticket->establishment_id
            ]);
        }

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupTicket::class,$this->ticket->id);
        $activity->causedBy($user);
        // $activity->routeOn(route('support_helpdesk_ticket_attend',myencrypt($ticketuser->id)));
        // $activity->componentOn('support.helpdesk.ticket-attend-resend');
        // $activity->dataOld($ticketuser);
        $activity->logType('update');
        $activity->log('paso el ticket a area id '.$this->sup_service_area_id.' y grupo id '.$this->sup_service_area_group_id);
        $activity->save();

        $this->dispatchBrowserEvent('response_success_ticket_solutions_store', ['message' => Lang::get('messages.successfully_registered')]);

        return redirect()->route('support_helpdesk_my_tickets_attended');
    }
}
