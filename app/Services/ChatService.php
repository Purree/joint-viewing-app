<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Room;
use App\Models\User;
use App\Services\Results\FunctionResult;

class ChatService
{
    public function getMessages(Room $room, int $messages_count = 100): FunctionResult
    {
        $messages = $room->messages()->with('user')->latest()->paginate($messages_count);

        return FunctionResult::success(
            new MessageCollection($messages)
        );
    }

    public function sendMessage(string $messageText, Room $room, User $user = null): FunctionResult
    {
        $message = $room->messages()->create([
            'user_id' => $user?->id,
            'message' => $messageText,
        ]);

        $message_resource = new MessageResource($message);

        broadcast(new MessageSent($message_resource));

        return FunctionResult::success($message_resource);
    }
}
