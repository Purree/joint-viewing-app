<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomCollection;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use App\Services\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $rooms = Room::where('is_private', false)->paginate($request->rooms_count ?: 15);

        return ResponseResult::success(new RoomCollection($rooms))->returnValue;
    }

    public function destroy(Request $request, Room $room): JsonResponse
    {
        $room->delete();

        return ResponseResult::success()->returnValue;
    }

    public function leave(Request $request, Room $room): JsonResponse
    {
        $result = $room->leave($request->user());
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error)->returnValue;
        }

        return ResponseResult::success()->returnValue;
    }
}
