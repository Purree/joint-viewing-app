<?php

namespace App\Http\Controllers;

use App\Helpers\Results\ResponseResult;
use App\Http\Requests\SendMessageRequest;
use App\Models\Room;
use App\Services\ChatService;
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
        );
    }

    public function send(SendMessageRequest $request, Room $room): JsonResponse
    {
        return ResponseResult::success(
            $this->chatService->sendMessage($request->message, $room, $request->user())
        );
    }
}
