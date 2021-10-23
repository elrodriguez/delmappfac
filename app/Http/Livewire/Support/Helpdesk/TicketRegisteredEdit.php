<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Master\Person;
use App\Models\Support\Administration\SupCategory;
use App\Models\Support\Administration\SupPanicLevel;
use App\Models\Support\Administration\SupReceptionMode;
use App\Models\Support\Administration\SupServiceArea;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketChat;
use App\Models\Support\Helpdesk\SupTicketFile;
use App\Models\Support\Helpdesk\SupTicketUser;
use App\Models\User;
use Carbon\Carbon;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketRegisteredEdit extends Component
{
    use WithFileUploads;

    public $areas_user;
    public $person;
    public $area_id;
    public $categories = [];
    public $subcategories = [];
    public $category_id;
    public $subcategory_id;
    public $registration_date;
    public $priorities = [];
    public $priority_id;
    public $receptions = [];
    public $reception_id;
    public $description;
    public $requesting_user_id;
    public $requesting_user_name;
    public $requesting_user_trade_name;
    public $files;
    public $ticket_id;
    public $files_olds;
    public $state;
    public $ticket_user;
    public $version_sicmact;

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);


        $this->ticket_user = SupTicketUser::where('sup_ticket_id',$this->ticket_id)
            ->where('type','applicant')
            ->with('users')
            ->first();

        $this->roles = $this->ticket_user->users->getRoleNames();
        $this->person = Person::find(Auth::user()->person_id);
        $this->requesting_person = Person::find($this->ticket_user->users->person_id);

        $this->requesting_user_name = $this->ticket_user->users->name;
        $this->requesting_user_trade_name = $this->requesting_person->trade_name;
        $this->requesting_user_id = $this->ticket_user->users->id;


        $this->areas_user = SupServiceArea::where('state',true)
            ->get()
            ->toArray();

        $this->categories = SupCategory::where('state',true)->whereNull('sup_category_id')->get()->toArray();

        $this->priorities = SupPanicLevel::where('state',true)->get()->toArray();

        $this->receptions = SupReceptionMode::where('state',true)->get()->toArray();

        $ticket = SupTicket::where('id',$this->ticket_id)->first();

        $this->area_id = $ticket->sup_service_area_id;
        $this->category_id = SupCategory::where('id',$ticket->sup_category_id)->value('sup_category_id');
        $this->subcategory_id = $ticket->sup_category_id;
        $this->registration_date = Carbon::parse($ticket->date_application)->format('d/m/Y');
        $this->priority_id = $ticket->sup_panic_level_id;
        $this->reception_id = $ticket->sup_reception_mode_id;
        $this->description = $ticket->description_of_problem;
        $this->state = $ticket->state;

        $this->loadSubCategories();

    }

    public function render()
    {
        $this->files_olds = SupTicketFile::where('sup_table_id',$this->ticket_id)
            ->where('sup_table_type',SupTicket::class)
            ->get();
        return view('livewire.support.helpdesk.ticket-registered-edit');
    }

    public function loadSubCategories(){
        $this->subcategories = SupCategory::where('sup_category_id',$this->category_id)->get()->toArray();
    }

    public function loadDescriptionDefault(){
        $this->description = SupCategory::find($this->subcategory_id)->detailed_description;
    }

    public function selectUser($id){
        $requesting_user = User::find($id);
        $this->requesting_user_id = $id;
        $this->requesting_user_name = $requesting_user->name;
        $this->requesting_user_trade_name = Person::find($requesting_user->person_id)->trade_name;
    }

    public function update(){
        //dd($this->files);
        $this->validate([
            'description' => 'required',
            'area_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'registration_date' => 'required',
            'priority_id' => 'required',
            'reception_id' => 'required'
        ]);

        $nom = date('YmdHis');
        if($this->files){
            $this->validate([
                'files' => 'file|max:5000|mimes:pdf',
            ]);
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $agenteDeUsuario = $_SERVER["HTTP_USER_AGENT"];
        $max = SupTIcket::max('id');

        list($d,$m,$y) = explode('/',$this->registration_date);

        $ticket = SupTicket::find($this->ticket_id);

        SupTicket::find($this->ticket_id)->update([
            'internal_id' => 'T-'.(($max == null?0:$max)+1),
            'sup_panic_level_id' => $this->priority_id,
            'sup_service_area_id' => 1,
            'sup_category_id' => $this->subcategory_id,
            'sup_reception_mode_id' => $this->reception_id,
            'establishment_id' => Auth::user()->establishment_id,
            'description_of_problem' => $this->description,
            'ip_pc' => $ip,
            'browser' => $agenteDeUsuario,
            'version_sicmact' => $this->version_sicmact,
            'state' => 'sent',
            'date_application' => ($y.'-'.$m.'-'.$d)
        ]);

        if($this->files){

            //foreach ($this->files as $file) {

                $this->files->storeAs('tickets/'.$ticket->id, $nom.'.pdf','public');

                SupTicketFile::create([
                    'sup_table_id' => $ticket->id,
                    'sup_table_type' => SupTicket::class,
                    'original_name' => $this->files->getClientOriginalName(),
                    'url' => 'tickets/'.$ticket->id.'/'.$nom.'.pdf',
                    'extension' => 'pdf',
                    'user_id' => Auth::id()
                ]);
            //}

        }

        SupTicketChat::where('sup_ticket_id',$ticket->id)->delete();

        $this->ticket_user->update([
            'user_id' => $this->requesting_user_id,
        ]);

        SupTicketChat::create([
            'sup_ticket_id' => $ticket->id,
            'user_id' => $this->requesting_user_id,
            'user' => User::find($this->requesting_user_id),
            'message' => $this->description
        ]);

        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(SupTicket::class,$ticket->id);
        $activity->causedBy($user);
        $activity->routeOn(route('support_helpdesk_my_tickets_registered_edit',myencrypt($ticket->id)));
        $activity->componentOn('support.helpdesk.ticket-registered-edit');
        $activity->dataOld($ticket);
        $activity->dataUpdated(SupTicket::find($this->ticket_id));
        $activity->logType('update');
        $activity->log('actualizo datos de ticket');
        $activity->save();

        $this->dispatchBrowserEvent('response_success_ticket_update', ['message' => Lang::get('messages.was_successfully_updated')]);

    }

    public function destroyFile($id){
        $file = SupTicketFile::where('id',$id)->first();
        $image_path = public_path("storage/{$file->url}");
        //dd($image_path);
        if (file_exists($image_path)) {
            //File::delete($image_path);
            unlink($image_path);
        }
        $file->delete();
    }
}
