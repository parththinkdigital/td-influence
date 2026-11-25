<?php

namespace App\Events;

use App\Models\AppNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationBroadcasted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public AppNotification $notification) {}

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.'.$this->notification->user_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'NotificationBroadcasted';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'user_id' => $this->notification->user_id,
            'sender_id' => $this->notification->sender_id,
            'type' => $this->notification->type,
            'title' => $this->notification->title,
            'body' => $this->notification->body,
            'action_url' => $this->notification->action_url,
            'data' => $this->notification->data,
            'created_at' => $this->notification->created_at?->toIso8601String(),
            'created_at_human' => $this->notification->created_at ? $this->notification->created_at->diffForHumans() : 'Just now',
        ];
    }
}
