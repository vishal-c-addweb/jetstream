<?php

namespace App\Events;

use App\Conversation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;

class MessageEvent
{
    use Dispatchable, SerializesModels;

    public $chat;

    public function __construct (Chat $chat) {
        $this->chat = $chat;
    }

    public function broadcastOn () {
        return;
    }
}