<?php

namespace App\Http\Controllers\Room;

use App\Events\RoomMemberKick;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Exceptions\UserNotFoundException;
use App\Helpers\Results\ResponseResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\JoinRoomRequest;
use App\Http\Resources\UserResource;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomMemberController extends Controller
{
    public function getAll(Request $request, Room $room): JsonResponse
    {
        return ResponseResult::success($room->members());
    }

    public function add(JoinRoomRequest $request, Room $room): JsonResponse
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

    public function leave(Request $request, Room $room): JsonResponse
    {
        try {
            $room->kick($request->user());
        } catch (UserNotFoundException $e) {
            return ResponseResult::error($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return ResponseResult::success();
    }
}
