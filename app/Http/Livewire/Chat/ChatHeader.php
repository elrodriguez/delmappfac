<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;

class ChatHeader extends Component
{
    public $name_contact;
    public $avatar_contact;
    public $email_contact;
    public $id_contact;
    public $id_room;

    protected $listeners = ['messages-room-id' => 'refreshHeader'];

    public function refreshHeader($data_inbox)
    {
        $this->id_contact = $data_inbox['id'];
        $this->name_contact = $data_inbox['name'];
        $this->email_contact = $data_inbox['email'];
        $this->avatar_contact = $data_inbox['profile_photo_path'];
        $this->id_room = $data_inbox['room_id'];
    }

    public function mount($data_inbox){
        $this->name_contact = $data_inbox['name'];
        $this->avatar_contact = $data_inbox['profile_photo_path'];
        $this->email_contact = $data_inbox['email'];
        $this->id_contact = $data_inbox['id'];
        $this->id_room = $data_inbox['room_id'];
    }

    public function render()
    {
        return view('livewire.chat.chat-header');
    }
}
