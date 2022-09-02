<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\EditRoomRequest;
use App\Http\Requests\JoinRoomRequest;
use App\Http\Resources\RoomCollection;
use App\Models\Room;
use App\Models\User;
use App\Services\Results\ResponseResult;
use App\Services\RoomService;
use App\Services\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(Request $request): JsonResponse
    {
        $rooms = Room::where('is_private', false)->paginate($request->rooms_count ?: 15);

        return ResponseResult::success(new RoomCollection($rooms))->returnValue;
    }

    public function show(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($this->roomService->show($room)->returnValue)->returnValue;
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
        $result = $this->roomService->create($request->user(), collect($request->validated()));
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error, Response::HTTP_UNPROCESSABLE_ENTITY)->error;
        }

        return ResponseResult::success($result->returnValue, Response::HTTP_CREATED)->returnValue;
    }

    public function kick(Request $request, Room $room, User $user): JsonResponse
    {
        $result = $room->kick($user);
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error, Response::HTTP_NOT_FOUND)->error;
        }

        return ResponseResult::success()->returnValue;
    }

    public function update(EditRoomRequest $request, Room $room): JsonResponse
    {
        $result = $this->roomService->update($room, collect($request->validated()));
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error, Response::HTTP_UNPROCESSABLE_ENTITY)->error;
        }

        return ResponseResult::success($result->returnValue)->returnValue;
    }

    public function join(JoinRoomRequest $request, Room $room): JsonResponse
    {
        $result = $request->user()->join($room, $request->password);
        if ($result->status === Status::ERROR) {
            return ResponseResult::error($result->error, Response::HTTP_UNPROCESSABLE_ENTITY)->error;
        }

        return ResponseResult::success($result->returnValue)->returnValue;
    }

    public function members(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($room->members())->returnValue;
    }
}
