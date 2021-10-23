<?php

namespace App\Http\Livewire\Onlineshop\Client;

use Livewire\Component;
use App\Models\Master\Company;
use App\Models\OnlineShop\ShoConfiguration;
use App\Models\OnlineShop\ShoCustomerMessages;

class PageContact extends Component
{
    public $configuration;
    public $company;

    public $names;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $person_id;
    public $customer_id;
    public $user_id;

    public function mount(){
        $this->configuration = ShoConfiguration::first();
        $this->company = Company::first();
    }

    public function render()
    {
        return view('livewire.onlineshop.client.page-contact');
    }

    protected $rules = [
        'names' => 'required',
        'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        'phone' => 'required',
        'subject' => 'required',
        'message' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save(){

        $this->validate();

        ShoCustomerMessages::create([
            'person_id' => $this->person_id,
            'customer_id' => $this->customer_id,
            'user_id' => $this->user_id,
            'name' => $this->names,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'rg',
            'message_id' => uuids()
        ]);

        $this->names = null;
        $this->email = null;
        $this->phone = null;
        $this->subject = null;
        $this->message = null;

        $this->dispatchBrowserEvent('response_contact_email_store', ['message' => 'Registrado correctamente, le responderemos en breve']);
    }
}
