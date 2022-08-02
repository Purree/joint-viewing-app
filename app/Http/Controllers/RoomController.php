<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomCollection;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $rooms = Room::where('is_private', false)->paginate($request->rooms_count ?: 15);

        return ResponseResult::success(new RoomCollection($rooms))->returnValue;
    }
}
