<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    return (int) $user->id === (int) $userId || $user->role === 'admin';
});

Broadcast::channel('chat.{conversationId}', function (User $user, int $conversationId) {
    $conversation = Conversation::find($conversationId);

    if (! $conversation) {
        return false;
    }

    return (int) $user->id === (int) $conversation->brand_user_id
        || (int) $user->id === (int) $conversation->talent_user_id
        || $user->role === 'admin';
});
