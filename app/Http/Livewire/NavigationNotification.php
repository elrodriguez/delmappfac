<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class NavigationNotification extends Component
{
    public $messages = [];
    public $notifications = 0;

    protected $listeners = ['notification-chat-refresh'=>'addNotificationsChat'];

    public function addNotificationsChat($data){
        $user = User::find($data['from_user_id']);
        $array = [
            'name' => $user->name,
            'content' => $data['content'],
            'created_at' => $data['created_at'],
            'avatar' => $user->profile_photo_path
        ];
        array_unshift($this->messages,$array);
        $this->notifications = $this->notifications + 1;
    }

    public function render()
    {
        return view('livewire.navigation-notification');
    }
}
