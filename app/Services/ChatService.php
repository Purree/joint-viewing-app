<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Room;
use App\Models\User;

class ChatService
{
    public function getMessages(Room $room, int $messagesCount = 100): MessageCollection
    {
        $messages = $room->messages()->with('user')->latest()->paginate($messagesCount);

        return new MessageCollection($messages);
    }

    public function sendMessage(string $messageText, Room $room, User $user = null): MessageResource
    {
        $message = $room->messages()->create([
            'user_id' => $user?->id,
            'message' => $messageText,
        ]);

        $messageResource = new MessageResource($message);

        broadcast(new MessageSent($messageResource));

        return $messageResource;
    }
}
