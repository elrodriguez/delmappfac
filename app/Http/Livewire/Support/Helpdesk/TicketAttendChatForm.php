<?php

namespace App\Http\Livewire\Support\Helpdesk;

use App\Models\Support\Helpdesk\SupTicket;
use App\Models\Support\Helpdesk\SupTicketChat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TicketAttendChatForm extends Component
{
    public $ticket_id;
    public $chat;
    public $msg;
    public $states_not = array('sent','attended','derivative');
    public $ticket_state;

    public function mount($ticket_id){
        $this->ticket_id = mydecrypt($ticket_id);
        $this->ticket_state = SupTicket::where('id',$this->ticket_id)->value('state');
    }

    public function render()
    {
        $this->getChat();
        return view('livewire.support.helpdesk.ticket-attend-chat-form');
    }

    public function getChat(){
        $this->chat = SupTicketChat::where('sup_ticket_id',$this->ticket_id)
            ->get()
            ->toArray();
    }

    public function store(){
        SupTicketChat::create([
            'sup_ticket_id' => $this->ticket_id,
            'user_id' => Auth::id(),
            'user' => Auth::user(),
            'message' => $this->msg
        ]);
        $this->msg = null;

        $this->dispatchBrowserEvent('response_success_ticket_chat_store', ['success' => true]);
    }

    public function sendEmoji($emoji){
        switch ($emoji) {
            case 1:
                $str = '<div class="emoji emoji--like">
                            <div class="emoji__hand">
                                <div class="emoji__thumb"></div>
                            </div>
                        </div>';
                break;
            case 2:
                $str = '<div class="emoji emoji--love">
                            <div class="emoji__heart"></div>
                        </div>';
                break;
            case 3:
                $str = '<div class="emoji emoji--haha">
                            <div class="emoji__face">
                                <div class="emoji__eyes"></div>
                                <div class="emoji__mouth">
                                    <div class="emoji__tongue"></div>
                                </div>
                            </div>
                        </div>';
                break;
            case 4:
                $str = '<div class="emoji emoji--yay">
                            <div class="emoji__face">
                                <div class="emoji__eyebrows"></div>
                                <div class="emoji__mouth"></div>
                            </div>
                        </div>';
                break;
            case 5:
                $str = '<div class="emoji emoji--wow">
                            <div class="emoji__face">
                                <div class="emoji__eyebrows"></div>
                                <div class="emoji__eyes"></div>
                                <div class="emoji__mouth"></div>
                            </div>
                        </div>';
                break;
            case 6:
                $str = '<div class="emoji emoji--sad">
                            <div class="emoji__face">
                                <div class="emoji__eyebrows"></div>
                                <div class="emoji__eyes"></div>
                                <div class="emoji__mouth"></div>
                            </div>
                        </div>';
                break;
            case 7:
                $str = '<div class="emoji emoji--angry">
                            <div class="emoji__face">
                                <div class="emoji__eyebrows"></div>
                                <div class="emoji__eyes"></div>
                                <div class="emoji__mouth"></div>
                            </div>
                        </div>';
                break;
        }

        SupTicketChat::create([
            'sup_ticket_id' => $this->ticket_id,
            'user_id' => Auth::id(),
            'user' => Auth::user(),
            'html' => true,
            'message' => htmlentities($str, ENT_QUOTES)
        ]);

        $this->dispatchBrowserEvent('response_success_ticket_chat_store', ['success' => true]);
    }
}
