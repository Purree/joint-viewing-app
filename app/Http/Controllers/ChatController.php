<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Models\Room;
use App\Services\ChatService;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService)
    {
    }

    public function index(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->chatService->getMessages($room, $request->messages_count ?: 100)
        )->returnValue;
    }

    public function send(SendMessageRequest $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->chatService->sendMessage($request->message, $room, $request->user())
        )->returnValue;
    }
}
