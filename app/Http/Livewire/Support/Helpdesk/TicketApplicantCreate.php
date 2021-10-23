<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Master\Person;
use App\Models\Support\Administration\SupCategory;
use App\Models\Support\Administration\SupPanicLevel;
use App\Models\Support\Administration\SupReceptionMode;
use App\Models\Support\Administration\SupServiceAreaUser;
use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketChat;
use App\Models\Support\Helpdesk\SupTicketFile;
use App\Models\Support\Helpdesk\SupTicketUser;
use App\Models\User;
use Carbon\Carbon;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketApplicantCreate extends Component
{
    use WithFileUploads;

    public $areas_user;
    public $person;
    public $area_id;
    public $categories = [];
    public $subcategories = [];
    public $category_id;
    public $subcategory_id;
    public $priorities = [];
    public $priority_id;
    public $description;
    public $requesting_user_id;
    public $requesting_user_name;
    public $requesting_user_trade_name;
    public $files;
    public $version_sicmact;

    public function mount(){
        $user = User::find(Auth::id());
        $this->person = Person::find($user->person_id);

        $this->requesting_user_name = $user->name;
        $this->requesting_user_trade_name = $this->person->trade_name;
        $this->requesting_user_id = $user->id;

        $this->area_id = 1;

        $this->categories = SupCategory::where('state',true)->whereNull('sup_category_id')->get()->toArray();

        $this->priorities = SupPanicLevel::where('state',true)->get()->toArray();

    }

    public function render()
    {
        return view('livewire.support.helpdesk.ticket-applicant-create');
    }

    public function loadSubCategories(){
        $this->subcategories = SupCategory::where('sup_category_id',$this->category_id)->get()->toArray();
    }

    public function loadDescriptionDefault(){
        $this->description = SupCategory::find($this->subcategory_id)->detailed_description;
    }

    public function store(){
        //dd($this->files);
        $this->validate([
            'description' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'priority_id' => 'required'
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

        $max = (int) SupTIcket::max(DB::raw("IFNULL(REPLACE(internal_id,'T-',''),0)"));

        $ticket = SupTicket::create([
            'internal_id' => 'T-'.($max+1),
            'sup_panic_level_id' => $this->priority_id,
            'sup_service_area_id' => 1,
            'sup_category_id' => $this->subcategory_id,
            'sup_reception_mode_id' => 4,
            'establishment_id' => Auth::user()->establishment_id,
            'description_of_problem' => $this->description,
            'ip_pc' => $ip,
            'browser' => $agenteDeUsuario,
            'version_sicmact' => $this->version_sicmact,
            'state' => 'sent',
            'date_application' => Carbon::now()->format('Y-m-d')
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

        SupTicketUser::create([
            'sup_ticket_id' => $ticket->id,
            'user_id' => $this->requesting_user_id,
            'type' => 'applicant',
            'incharge' => false
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
        $activity->routeOn(route('support_helpdesk_ticket_create'));
        $activity->componentOn('support.helpdesk.ticket-create-form');
        $activity->dataOld($ticket);
        $activity->logType('create');
        $activity->log('Registró un nuevo ticket');
        $activity->save();

        $this->clearForm();

        $this->dispatchBrowserEvent('response_success_ticket_store', ['message' => Lang::get('messages.successfully_registered')]);

    }

    private function clearForm(){
        $this->priority_id = null;
        $this->subcategory_id = null;
        $this->description = null;
        $this->category_id = null;
        $this->requesting_user_id = Auth::id();
        $this->requesting_user_name = Auth::user()->name;
        $this->requesting_user_trade_name = $this->person->trade_name;
        $this->files = null;
    }
}
