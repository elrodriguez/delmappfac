<?php

namespace App\Events\chat;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessagesSide implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $from_user_id;
    public $to_user_id;
    public $content;
    public $created_at;

    public function __construct($from_user_id,$to_user_id,$message,$created_at)
    {
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->content = $message;
        $this->created_at = $created_at;
    }
    public function broadcastOn()
    {
        return 'chat-side-channel';
    }
    public function broadcastAs()
    {
        return 'chat-side-event';
    }
}
