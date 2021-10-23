<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoCustomerMessages;
use Livewire\Component;

class ReadMessage extends Component
{
    public $message_id;
    public $message;
    public $answers;

    protected $listeners = [
        'customer-messages-answers' => 'getAnswers',
    ];

    public function mount($message_id){
        $this->message_id = $message_id;
    }

    public function render()
    {
        $this->getMessage();
        return view('livewire.onlineshop.admin.read-message');
    }

    public function getMessage(){
        $this->message = ShoCustomerMessages::leftJoin('users','sho_customer_messages.user_id','users.id')
            ->select(
                'sho_customer_messages.id',
                'sho_customer_messages.name',
                'sho_customer_messages.email',
                'sho_customer_messages.phone',
                'sho_customer_messages.subject',
                'sho_customer_messages.message',
                'sho_customer_messages.status',
                'sho_customer_messages.message_id',
                'sho_customer_messages.created_at',
                'users.profile_photo_path'
            )
            ->where('message_id',$this->message_id)
            ->first();
        $this->getAnswers();
    }
    
    public function getAnswers(){
        $this->answers =  ShoCustomerMessages::where('customer_message_id',$this->message->id)->get();
    }
}
