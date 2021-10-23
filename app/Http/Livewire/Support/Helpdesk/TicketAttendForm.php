<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketFile;
use App\Models\Support\Helpdesk\SupTicketUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\WithFileUploads;
use Livewire\Component;
use Elrod\UserActivity\Activity;

class TicketAttendForm extends Component
{
    use WithFileUploads;

    public $ticket_id;
    public $ticket;
    public $files;
    public $states_not = array('sent','attended');

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);
    }
    public function render()
    {
        $this->loadTicket();
        return view('livewire.support.helpdesk.ticket-attend-form');
    }

    public function loadTicket(){
        $ticket = SupTicket::join('sup_panic_levels','sup_tickets.sup_panic_level_id','sup_panic_levels.id')
            ->join('sup_reception_modes','sup_tickets.sup_reception_mode_id','sup_reception_modes.id')
            ->join('sup_service_areas','sup_tickets.sup_service_area_id','sup_service_areas.id')
            ->join('sup_categories','sup_tickets.sup_category_id','sup_categories.id')
            ->join('sup_categories AS c2','sup_categories.sup_category_id','c2.id')
            ->join('establishments','sup_tickets.establishment_id','establishments.id')
            ->where('sup_tickets.id',$this->ticket_id)
            ->select(
                'sup_panic_levels.description AS level_description',
                'sup_reception_modes.description AS reception_description',
                'sup_service_areas.description AS area_description',
                'sup_categories.short_description AS subcategory_description',
                'sup_categories.detailed_description AS subcategory_detailed_description',
                'c2.short_description AS category_description',
                'establishments.name AS establishment_name',
                'sup_tickets.date_application',
                'sup_tickets.id',
                'sup_tickets.version_sicmact',
                'sup_tickets.state',
                'sup_tickets.internal_id',
                'sup_tickets.description_of_problem',
                'ip_pc',
                'browser',
                'sup_panic_level_id'
            )
            ->first()
            ->toArray();

        $applicant = SupTicketUser::join('users','sup_ticket_users.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->where('sup_ticket_id',$this->ticket_id)
            ->where('sup_ticket_users.type','applicant')
            ->select(
                'users.id',
                'users.email',
                'users.profile_photo_path',
                'people.trade_name',
                'users.name'
            )
            ->first()
            ->toArray();

        $xtechnical = array();
        $technical = SupTicketUser::join('users','sup_ticket_users.user_id','users.id')
            ->join('people','users.person_id','people.id')
            ->where('sup_ticket_id',$this->ticket_id)
            ->where('sup_ticket_users.type','technical')
            ->where('incharge',true)
            ->select(
                'users.email',
                'users.profile_photo_path',
                'people.trade_name',
                'users.name'
            )
            ->first();

        if($technical){
            $xtechnical = $technical->toArray();
        }

        $files = SupTicketFile::where('sup_table_id',$this->ticket_id)
            ->where('sup_table_type',SupTicket::class)
            ->get()
            ->toArray();

        $this->ticket = [
            'ticket' => $ticket,
            'applicant' => $applicant,
            'technical' => $xtechnical,
            'files' => $files
        ];
        //dd($this->ticket);
    }

    public function addFile(){

        $this->validate([
            'files' => 'file|max:50000|mimes:pdf',
        ]);

        $nom = date('YmdHis');

        $this->files->storeAs('tickets/'.$this->ticket_id, $nom.'.pdf','public');

        $ticket_file = SupTicketFile::create([
            'sup_table_id' => $this->ticket_id,
            'sup_table_type' => SupTicket::class,
            'original_name' => $this->files->getClientOriginalName(),
            'url' => 'tickets/'.$this->ticket_id.'/'.$nom.'.pdf',
            'extension' => 'pdf',
            'user_id' => Auth::id()
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupTicketFile::class,$ticket_file->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_helpdesk_ticket_attend',myencrypt($this->ticket_id)));
        $activity->componentOn('support.helpdesk.ticket-attend-form');
        $activity->dataOld($ticket_file);
        $activity->logType('create');
        $activity->log('Registró un archivo adicional al ticket');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_ticket_store_file', ['message' => Lang::get('messages.successfully_registered')]);
    }
}
