<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoConfiguration;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class ConfigurationsReplyMail extends Component
{
    public $email_default;
    public $configuration;

    public function render()
    {
        $this->configuration = ShoConfiguration::first();
        return view('livewire.onlineshop.admin.configurations-reply-mail');
    }

    public function save(){
        $this->validate([
            'email_default' => 'required'
        ]);
        $this->configuration->update(['email_default' => $this->email_default]);

        $this->dispatchBrowserEvent('response_configurations_reply_mail_save', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
