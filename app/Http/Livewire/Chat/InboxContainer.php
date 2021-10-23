<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat\Message;
use Illuminate\Support\Facades\Auth;

class InboxContainer extends Component
{

    public $data_inbox = [];

    public function mount(){
        $id = Auth::id();
        $data_user = Message::join('users','messages.to_user_id','users.id')
            ->where('messages.from_user_id',$id)
            ->select('users.id','users.name','users.email','users.profile_photo_path','messages.room_id')
            ->orderBy('messages.created_at','DESC')
            ->first();
        if(!$data_user){
            $data_user = Message::join('users','messages.from_user_id','users.id')
                ->where('messages.to_user_id',$id)
                ->select('users.id','users.name','users.email','users.profile_photo_path','messages.room_id')
                ->orderBy('messages.created_at','DESC')
                ->first();
        }

        if($data_user){
            $this->data_inbox = [
                'id' => $data_user->id,
                'name' => $data_user->name,
                'email' => $data_user->email,
                'profile_photo_path' => $data_user->profile_photo_path,
                'room_id' => $data_user->room_id,
            ];
        }else{
            $this->data_inbox = [
                'id' => 0,
                'name' => 'none',
                'email' => 'none',
                'profile_photo_path' => 'none',
                'room_id' => 0,
            ];
        }
    }
    public function render()
    {
        return view('livewire.chat.inbox-container');
    }
}
