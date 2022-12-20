<?php

namespace App\Services;

use App\DataTransferObjects\RoomCreationDTO;
use App\Events\RoomUpdate;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Exceptions\UserNotFoundException;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class RoomService
{
    protected function filterParameters(Collection $parameters): Collection
    {
        return $parameters->filter(static function ($value) {
            return ! is_null($value);
        });
    }

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
    public function create(User $user, RoomCreationDTO $roomCreationDTO): RoomResource
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
    public function update(Room $room, Collection $parameters): Room
    {
        $parameters = $this->filterParameters($parameters);

        if (($room->password === null || ! $parameters->has('password')) && $parameters['is_closed']) {
            throw new InvalidArgumentException('The password must be present when closing the channel.');
        }

        $room->update(
            [
                'name' => $parameters['name'],
                'is_closed' => $parameters['is_closed'],
                'is_private' => $parameters['is_private'],
                'can_everyone_control' => $parameters['can_everyone_control'],
            ] +
            (! $parameters['is_closed'] ? ['password' => null] : []) +
            ($parameters->has('password') && ($parameters['is_closed'] || $room->is_closed) ?
                ['password' => Hash::make($parameters['password'])] :
                [])
        );
        $room->save();

        broadcast(new RoomUpdate($this->getRoomData($room)));

        return $room;
    }

    public function show(Room $room): RoomResource
    {
        return $this->getRoomData($room);
    }
}
