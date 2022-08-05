<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Resources\RoomCollection;
use App\Models\Room;
use App\Services\Results\ResponseResult;
use App\Services\Status;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $result = $room->kick($request->user());
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error, Response::HTTP_NOT_FOUND)->error;
        }

        return ResponseResult::success()->returnValue;
    }

    public function create(CreateRoomRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user->createdRoom) {
            return ResponseResult::error('You are already have a room.', Response::HTTP_CONFLICT)->error;
        }

        if ($user->currentRoom) {
            $user->currentRoom->kick($user);
        }

        $room = Room::create([
            'owner_id' => $user->id,
            'name' => $request->name,
            'link' => $request->link ?: uniqid('', true),
            'is_closed' => $request->has('is_closed'),
            'can_everyone_control' => $request->has('can_everyone_control'),
            'is_private' => $request->has('is_private'),
            'password' => $request->password === null || ! $request->has('is_closed') ?
                null :
                Hash::make($request->password),
        ]);

        $user->current_room_id = $room->id;
        $user->save();

        return ResponseResult::success()->returnValue;
    }
}
