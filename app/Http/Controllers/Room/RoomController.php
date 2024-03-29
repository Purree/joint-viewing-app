<?php

namespace App\Http\Controllers\Room;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Helpers\Results\ResponseResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\EditRoomRequest;
use App\Http\Resources\RoomCollection;
use App\Models\Room;
use App\Services\RoomService;
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

    public function getAll(Request $request): JsonResponse
    {
        $rooms = Room::where('is_private', false)->paginate($request->rooms_count ?: 15);

        return ResponseResult::success(new RoomCollection($rooms));
    }

    public function get(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($this->roomService->get($room));
    }

    public function destroy(Request $request, Room $room): JsonResponse
    {
        $room->delete();

        return ResponseResult::success();
    }

    public function create(CreateRoomRequest $request): JsonResponse
    {
        try {
            $roomCreatingResult = $this->roomService->create(
                $request->user(),
                $request->toDTO()
            );
        } catch (UserAlreadyInRoomException|InvalidArgumentException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ResponseResult::success($roomCreatingResult, Response::HTTP_CREATED);
    }

    public function update(EditRoomRequest $request, Room $room): JsonResponse
    {
        try {
            $roomUpdatingResult = $this->roomService->update($room, $request->toDTO());
        } catch (InvalidArgumentException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ResponseResult::success($roomUpdatingResult);
    }
}
