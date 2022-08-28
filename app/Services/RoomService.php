<?php

namespace App\Services;

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
            $user->currentRoom->kick($user);
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

        return FunctionResult::success();
    }

    public function show(Room $room): FunctionResult
    {
        return FunctionResult::success(
            new RoomResource(
                Room::when($room->have(\Auth::user()), function ($query) {
                    $query->with('owner');
                })->take($room->id)->first()
            )
        );
    }
}
