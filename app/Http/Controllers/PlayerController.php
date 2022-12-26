<?php

namespace App\Http\Controllers;

use App\Events\PlayerSynchronize;
use App\Events\PlayerSynchronizeRequest;
use App\Helpers\Results\ResponseResult;
use App\Http\Requests\SynchronizationRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function synchronizationRequest(Request $request, Room $room): JsonResponse
    {
        broadcast(new PlayerSynchronizeRequest($room->id, $request->user()->id));

        return ResponseResult::success();
    }

    public function synchronize(SynchronizationRequest $request, Room $room): JsonResponse
    {
        broadcast(
            new PlayerSynchronize(
                $room->id,
                $request->user()->id,
                $request->time,
                $request->is_paused,
                $request->playback_rate,
                $request->synchronizer_timestamp,
                $request->additional_data ?? []
            )
        );

        return ResponseResult::success();
    }
}
