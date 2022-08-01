<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    public function index(): JsonResponse
    {
        $rooms = Room::where('is_private', false)->get();

        return ResponseResult::success(RoomResource::collection($rooms))->returnValue;
    }
}
