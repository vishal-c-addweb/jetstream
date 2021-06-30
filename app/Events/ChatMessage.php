<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */ 
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }
    // public function broadcastAs () {
    //     return 'message-received';
    // }

    // public function broadcastQueue () {
    //     return 'broadcastable';
    // }

    // public function broadcastWith () {
    //     return [
    //         'id' => $this->chat->id,
    //         'sender_id'  => $this->chat->sender_id,
    //         'receiver_id'  => $this->chat->receiver_id,
    //         'message' => $this->chat->message,
    //         'file' => $this->chat->file,
    //         'time' => $this->chat->time,
    //         'status' => $this->chat->status,
    //     ];
    // }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }
}
