<?php

namespace App\Services;

use App\Events\RoomUpdate;
use App\Exceptions\UserNotFoundException;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\User;
use App\Services\Results\FunctionResult;
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

    public function create(User $user, Collection $parameters): FunctionResult
    {
        $parameters = $this->filterParameters($parameters);

        if ($user->createdRoom) {
            return FunctionResult::error('You are already have a room.');
        }

        if ($parameters['is_closed'] && ! $parameters->has('password')) {
            return FunctionResult::error('Password is required when room is closed.');
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
            'name' => $parameters['name'],
            'link' => $parameters->has('link') ? $parameters['link'] : uniqid('', true),
            'is_closed' => $parameters['is_closed'],
            'can_everyone_control' => $parameters['can_everyone_control'],
            'is_private' => $parameters['is_private'],
            'password' => $parameters->has('password') && $parameters['is_closed'] ?
                Hash::make($parameters['password']) :
                null,
        ]);

        $user->current_room_id = $room->id;
        $user->save();

        return FunctionResult::success(new RoomResource($room));
    }

    public function update(Room $room, Collection $parameters): FunctionResult
    {
        $parameters = $this->filterParameters($parameters);

        if ($room->password === null && $parameters['is_closed'] && ! $parameters->has('password')) {
            return FunctionResult::error('The password must be present when closing the channel.');
        }

        $room->update(
            $parameters->only([
                'name',
            ])->toArray() +
            ['is_closed' => $parameters['is_closed']] +
            ['is_private' => $parameters['is_private']] +
            ['can_everyone_control' => $parameters['can_everyone_control']] +
            (! $parameters['is_closed'] ? ['password' => null] : []) +
            ($parameters->has('password') && ($parameters['is_closed'] || $room->is_closed) ?
                ['password' => Hash::make($parameters['password'])] :
                [])
        );
        $room->save();

        broadcast(new RoomUpdate($this->getRoomData($room)));

        return FunctionResult::success($room);
    }

    public function show(Room $room): FunctionResult
    {
        return FunctionResult::success(
            $this->getRoomData($room)
        );
    }
}
