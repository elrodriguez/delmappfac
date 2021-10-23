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
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketCreateForm extends Component
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
    public $version_sicmact;

    public function mount(){
        $user = User::find(Auth::id());
        $this->roles = $user->getRoleNames();
        $this->person = Person::find($user->person_id);

        $this->requesting_user_name = $user->name;
        $this->requesting_user_trade_name = $this->person->trade_name;
        $this->requesting_user_id = $user->id;


        $this->areas_user = SupServiceAreaUser::join('sup_service_areas','sup_service_area_users.sup_service_area_id','sup_service_areas.id')
            ->select(
                'sup_service_areas.id',
                'sup_service_areas.description'
            )
            ->where('sup_service_area_users.user_id',$user->id)
            ->get()
            ->toArray();
        $this->area_id = $this->areas_user[0]['id'];

        $this->categories = SupCategory::where('state',true)->whereNull('sup_category_id')->get()->toArray();

        $this->priorities = SupPanicLevel::where('state',true)->get()->toArray();

        $this->receptions = SupReceptionMode::where('state',true)->get()->toArray();

    }
    public function render()
    {
        return view('livewire.support.helpdesk.ticket-create-form');
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

        $ticket = SupTicket::create([
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

        SupTicketUser::create([
            'sup_ticket_id' => $ticket->id,
            'user_id' => $this->requesting_user_id,
            'type' => 'applicant',
            'incharge' => false
        ]);

        $user_area = SupServiceAreaUser::where('user_id',Auth::id())->first();

        SupTicketUser::create([
            'sup_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'type' => 'checkin',
            'incharge' => true,
            'sup_service_area_id' => $user_area->sup_service_area_id
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

    public function selectUser($id){
        $requesting_user = User::find($id);
        $this->requesting_user_id = $id;
        $this->requesting_user_name = $requesting_user->name;
        $this->requesting_user_trade_name = Person::find($requesting_user->person_id)->trade_name;
    }

    private function clearForm(){
        $this->registration_date = Carbon::now()->format('d/m/Y');
        $this->priority_id = null;
        $this->subcategory_id = null;
        $this->reception_id = null;
        $this->description = null;
        $this->category_id = null;
        $this->requesting_user_id = Auth::id();
        $this->requesting_user_name = Auth::user()->name;
        $this->requesting_user_trade_name = $this->person->trade_name;
        $this->files = null;
    }
}
