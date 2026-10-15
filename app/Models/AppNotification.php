<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    use HasFactory;

    protected $table = 'app_notifications';

    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'title',
        'body',
        'action_url',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function markAsRead(): bool
    {
        return $this->update(['read_at' => now()]);
    }

    public static function send(
        int $userId,
        string $title,
        string $body,
        ?string $actionUrl = null,
        string $type = 'message',
        ?int $senderId = null,
        ?array $data = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'sender_id' => $senderId,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'action_url' => $actionUrl,
            'data' => $data,
        ]);
    }
}
