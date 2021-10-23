<?php

namespace App\Http\Livewire\Support\Helpdesk;


use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Lang;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketFile;
use App\Models\Support\Helpdesk\SupTicketSolution;
use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\Support\Helpdesk\SupTicketRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;

class TicketAttendSolutionRegister extends Component
{
    use WithFileUploads;

    public $solution;
    public $ticket_id;
    public $ticket;
    public $file;
    public $closed = 'closed_ok';

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);
        $this->ticket = SupTicket::find($this->ticket_id);
    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-attend-solution-register');
    }

    public function store(){
        if($this->ticket->sup_service_area_id == 1){
            $this->validate([
                'solution' => 'required'
            ]);

            $nom = date('YmdHis');

            if($this->file){
                $this->validate([
                    'file' => 'file|max:5000|mimes:pdf',
                ]);

                $this->file->storeAs('tickets/'.$this->ticket->id.'/solutions/', $nom.'.pdf','public');

            }

            $user_id = Auth::id();
            $msg = '';

            if($this->closed == 'cancel'){
                $this->ticket->update([
                    'state' => $this->closed,
                    'date_finished' => Carbon::now()->format('Y-m-d'),
                    'description_completion_rejection' => $this->solution
                ]);
                $ticket = $this->ticket;
                $msg = 'rechazado';
            }else{
                $ticket = SupTicketSolution::create([
                    'sup_category_id' => $this->ticket->sup_category_id,
                    'sup_ticket_id' => $this->ticket->id,
                    'user_id' => $user_id,
                    'solution_description' => $this->solution
                ]);

                $this->ticket->update([
                    'state' => $this->closed,
                    'date_finished' => Carbon::now()->format('Y-m-d')
                ]);

                $msg = 'Registro una solucion como finalizado';
            }

            $area_user = SupServiceAreaUser::where('user_id',Auth::id())->select('sup_service_area_id','sup_service_area_group_id')->first();
            
            SupTicketRecord::create([
                'sup_ticket_id' => $this->ticket_id,
                'user_id' => Auth::id(),
                'from_area_id' => $area_user->sup_service_area_id,
                'from_group_id' => $area_user->sup_service_area_group_id,
                'description' => $this->solution,
                'state' => $this->closed,
                'establishment_id' => $this->ticket->establishment_id
            ]);


            if($this->file){
                SupTicketFile::create([
                    'sup_table_id' => $ticket->id,
                    'sup_table_type' => SupTicketSolution::class,
                    'original_name' => $this->file->getClientOriginalName(),
                    'url' => 'tickets/'.$this->ticket->id.'/solutions/'.$nom.'.pdf',
                    'extension' => 'pdf',
                    'user_id' => $user_id
                ]);
            }

            $user = Auth::user();
            $activity = new Activity;
            $activity->modelOn(SupTicket::class,$ticket->id);
            $activity->causedBy($user);
            $activity->routeOn(route('support_helpdesk_ticket_attend',myencrypt($this->ticket->id)));
            $activity->componentOn('support.helpdesk.ticket-attend-solution-register');
            $activity->dataOld($ticket);
            $activity->logType('create');
            $activity->log($msg);
            $activity->save();

            $this->solution = null;
            $this->file = null;

            $this->dispatchBrowserEvent('response_success_ticket_solutions_store', ['message' => Lang::get('messages.successfully_registered')]);
            
            return redirect()->route('support_helpdesk_my_tickets_attended');
        }

    }
}
