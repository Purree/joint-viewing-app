<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\SendMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            MessageResource::collection($room->messages()->with('user')->get())
        )->returnValue;
    }

    public function send(SendMessageRequest $request, Room $room): JsonResponse
    {
        $message = $room->messages()->create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        $message_resource = new MessageResource($message);

        broadcast(new MessageSent($message_resource));
        return ResponseResult::success($message_resource)->returnValue;
    }
}
