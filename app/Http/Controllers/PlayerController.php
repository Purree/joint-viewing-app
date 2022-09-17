<?php

namespace App\Http\Controllers;

use App\Events\PlayerSynchronize;
use App\Events\PlayerSynchronizeRequest;
use App\Http\Requests\SynchronizationRequest;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function synchronizationRequest(Request $request, Room $room): JsonResponse
    {
        broadcast(new PlayerSynchronizeRequest($room->id, $request->user()->id));

        return ResponseResult::success()->returnValue;
    }

    public function synchronize(SynchronizationRequest $request, Room $room): JsonResponse
    {
        broadcast(
            new PlayerSynchronize(
                $room->id,
                $request->time,
                $request->is_paused,
                $request->playback_rate,
                $request->synchronizer_timestamp
            )
        );

        return ResponseResult::success()->returnValue;
    }
}
