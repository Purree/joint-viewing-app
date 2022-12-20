<?php

namespace App\Http\Controllers;

use App\Events\RoomMemberKick;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Exceptions\UserNotFoundException;
use App\Helpers\Results\ResponseResult;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\EditRoomRequest;
use App\Http\Requests\JoinRoomRequest;
use App\Http\Resources\RoomCollection;
use App\Http\Resources\UserResource;
use App\Models\Room;
use App\Models\User;
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

    public function index(Request $request): JsonResponse
    {
        $rooms = Room::where('is_private', false)->paginate($request->rooms_count ?: 15);

        return ResponseResult::success(new RoomCollection($rooms));
    }

    public function show(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($this->roomService->show($room));
    }

    public function destroy(Request $request, Room $room): JsonResponse
    {
        $room->delete();

        return ResponseResult::success();
    }

    public function leave(Request $request, Room $room): JsonResponse
    {
        try {
            $room->kick($request->user());
        } catch (UserNotFoundException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return ResponseResult::success();
    }

    public function create(CreateRoomRequest $request): JsonResponse
    {
        try {
            $roomCreatingResult = $this->roomService->create($request->user(), collect($request->validated()));
        } catch (UserAlreadyInRoomException|InvalidArgumentException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ResponseResult::success($roomCreatingResult, Response::HTTP_CREATED);
    }

    public function kick(Request $request, Room $room, User $user): JsonResponse
    {
        try {
            $room->kick($user);
        } catch (UserNotFoundException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        broadcast(new RoomMemberKick(new UserResource($user), $room->id));

        return ResponseResult::success();
    }

    public function update(EditRoomRequest $request, Room $room): JsonResponse
    {
        try {
            $roomUpdatingResult = $this->roomService->update($room, collect($request->validated()));
        } catch (InvalidArgumentException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return ResponseResult::success($roomUpdatingResult);
    }

    public function join(JoinRoomRequest $request, Room $room): JsonResponse
    {
        try {
            $roomJoiningResult = $request->user()->join($room, $request->password);
        } catch (UserAlreadyInRoomException $e) {
            return ResponseResult::error(['room' => [$e->getMessage()]], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (InvalidArgumentException $e) {
            return ResponseResult::error(
                [
                    'password' => [$e->getMessage()],
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return ResponseResult::success($roomJoiningResult);
    }

    public function members(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($room->members());
    }
}
