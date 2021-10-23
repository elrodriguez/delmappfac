<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Mail\ContactMailable;
use App\Models\Master\Person;
use App\Models\Master\SocialMedia;
use App\Models\OnlineShop\ShoConfiguration;
use App\Models\OnlineShop\ShoCustomerMessages;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CustomerMessagesCompose extends Component
{
    protected $listeners = [
        'customer-messages-compose-for' => 'newComposeFor',
        'customer-messages-compose-new' => 'clearFormMessages'
    ];

    public $email_to;
    public $email_to_cc;
    public $subject;
    public $name_to;
    public $title;
    public $config;
    public $social_media;
    public $message_text;
    public $customer_message_id;
    public $answers;

    public function mount(){
        $this->title = Lang::get('messages.message_title_new');
        $this->config = ShoConfiguration::first();
        $this->social_media = SocialMedia::all();
    }

    public function render()
    {
        return view('livewire.onlineshop.admin.customer-messages-compose');
    }

    public function newComposeFor($message_id){

        $message = ShoCustomerMessages::where('message_id',$message_id)->first();
        $this->title = Lang::get('messages.message_title_answer');
        $this->email_to = $message->email;
        $this->name_to = $message->name;
        $this->message_text = $this->config->email_default;
        $this->customer_message_id = $message->id;
        $this->dispatchBrowserEvent('sho_load_message_default', ['message' => $this->message_text]);
    }

    public function messageSend(){



        $this->validate([
            'email_to' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'message_text' => 'required',
            'subject' => 'required'
        ]);

        $data = array(
            'name_to' => $this->name_to,
            'email_to' => $this->email_to,
            'message_text' => $this->message_text,
            'logo' => $this->config->logo
        );

        $body = new ContactMailable($this->subject,$data);
        $message = '';

        try{
            Mail::to($this->email_to)->send($body);
            $person = Person::find(Auth::user()->person_id);

            ShoCustomerMessages::create([
                'person_id' => Auth::user()->person_id,
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => $person->telephone,
                'subject' => $this->subject,
                'message' => $this->message_text,
                'status' => 'rg',
                'customer_message_id' => $this->customer_message_id,
                'message_id' => uuids(),
                'send' => true
            ]);

            if($this->customer_message_id){
                ShoCustomerMessages::find($this->customer_message_id)
                    ->update([
                        'status' => 'rp'
                    ]);
                $this->emit('customer-messages-answers');
            }

            $this->clearFormMessages();

            $message = Lang::get('messages.the_mail_was_sent');
            
        }catch(Exception $e){
            $message = $e->getMessage();
        }
        
        $this->dispatchBrowserEvent('response_contact_email_store', ['message' => $message]);
    }

    public function clearFormMessages(){
        $this->title = Lang::get('messages.message_title_new');
        $this->email_to = null;
        $this->name_to = null;
        $this->message_text = null;
        $this->customer_message_id = null;
        $this->subject = null;
    }
}
