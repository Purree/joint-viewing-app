<?php

namespace App\Services;

use App\DataTransferObjects\CreateRoomDTO;
use App\DataTransferObjects\UpdateRoomDTO;
use App\Events\RoomUpdate;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Exceptions\UserNotFoundException;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoomService
{
    protected function getRoomData(Room $room): RoomResource
    {
        return new RoomResource(
            $room->getWithOwner()
        );
    }

    /**
     * @throws UserAlreadyInRoomException
     * @throws InvalidArgumentException
     */
    public function create(User $user, CreateRoomDTO $roomCreationDTO): RoomResource
    {
        if ($user->createdRoom) {
            throw new UserAlreadyInRoomException('You are already have a room.');
        }

        if ($roomCreationDTO->isClosed && ! $roomCreationDTO->password) {
            throw new InvalidArgumentException('Password is required when room is closed.');
        }

        if ($user->currentRoom) {
            try {
                $user->currentRoom->kick($user);
            } catch (UserNotFoundException $e) {
                \Log::error($e);
            }
        }

        $room = Room::create([
            'owner_id' => $user->id,
            'name' => $roomCreationDTO->name,
            'link' => $roomCreationDTO->link ?: uniqid('', true),
            'is_closed' => $roomCreationDTO->isClosed,
            'can_everyone_control' => $roomCreationDTO->canEveryoneControl,
            'is_private' => $roomCreationDTO->isPrivate,
            'password' => $roomCreationDTO->password && $roomCreationDTO->isClosed ?
                Hash::make($roomCreationDTO->password) :
                null,
        ]);

        $user->current_room_id = $room->id;
        $user->save();

        return new RoomResource($room);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function update(Room $room, UpdateRoomDTO $updateRoomDTO): Room
    {
        if (! $updateRoomDTO->password && $updateRoomDTO->isClosed) {
            throw new InvalidArgumentException('The password must be present when closing the channel.');
        }

        $room->update(
            [
                'name' => $updateRoomDTO->name,
                'is_closed' => $updateRoomDTO->isClosed,
                'is_private' => $updateRoomDTO->isPrivate,
                'can_everyone_control' => $updateRoomDTO->canEveryoneControl,
                'password' => $updateRoomDTO->isClosed ? Hash::make($updateRoomDTO->password) : null,
            ]
        );
        $room->save();

        broadcast(new RoomUpdate($this->getRoomData($room)));

        return $room;
    }

    public function get(Room $room): RoomResource
    {
        return $this->getRoomData($room);
    }
}
