<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat\Room;
use App\Models\Chat\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\chat\SendMessagesSide;

class ChatMessages extends Component
{
    public $room_id;
    public $user_id;
    public $content;
    public $messages = [];

    protected $listeners = ['messages-room-id' => 'refreshMessages','messages-refresh'=>'addMessage'];

    public function addMessage($data){
        $this->messages[] = $data;
    }
    public function refreshMessages($data_inbox)
    {
        $this->room_id = $data_inbox['room_id'];
        $this->user_id = $data_inbox['id'];
        $this->getMessages();
    }

    public function mount($data_inbox){
        $this->room_id = $data_inbox['room_id'];
        $this->user_id = $data_inbox['id'];
        $this->getMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat-messages');
    }

    public function getMessages(){
        //dd($this->room_id);
        if($this->room_id != null){
            $data_messages = Message::where('messages.room_id',$this->room_id)
            ->select(
                'messages.from_user_id',
                'messages.to_user_id',
                'messages.content',
                'messages.created_at'
            )->get();
            $items =[];
            foreach($data_messages as $key => $item){
                $items[$key] = [
                    'from_user_id' => $item['from_user_id'],
                    'to_user_id' => $item['to_user_id'],
                    'content' => $item['content'],
                    'created_at' => $item['created_at']
                ];
            }
            $this->messages = $items;
        }else{
            $this->messages = [];
        }
    }

    public function sendMessage(){
        $room = Room::find($this->room_id);
        if($room){
            $this->saveMessage($room->id);
        }else{
            $data_room = Room::create([
                'creator_id'=> Auth::id(),
                'member_id' => $this->user_id,
                'room_index' => (Auth::id().$this->user_id)
            ]);
            $this->saveMessage($data_room->id);
        }
    }

    public function saveMessage($id){
        $data_message = Message::create([
            'room_id' => $id,
            'from_user_id' => Auth::id(),
            'to_user_id' => $this->user_id,
            'content' => $this->content
        ]);
        event(new SendMessagesSide($data_message->from_user_id,$data_message->to_user_id,$data_message->content,$data_message->created_at));
        $this->content = null;
    }

}
