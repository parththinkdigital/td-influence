<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message) {}

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.'.$this->message->conversation_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $sender = $this->message->sender;

        return [
            'id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $sender ? ($sender->brandProfile->company_name ?? ($sender->talentProfile->display_name ?? $sender->name)) : 'User',
            'message_text' => $this->message->message_text,
            'attachments' => $this->message->attachments,
            'proposal_price' => $this->message->proposal_price,
            'proposal_status' => $this->message->proposal_status,
            'usage_rights' => $this->message->usage_rights,
            'revisions_included' => $this->message->revisions_included,
            'exclusivity_days' => $this->message->exclusivity_days,
            'created_at' => $this->message->created_at?->toIso8601String(),
            'created_at_human' => $this->message->created_at ? $this->message->created_at->diffForHumans() : 'Just now',
        ];
    }
}
