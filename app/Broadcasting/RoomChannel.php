<?php

namespace App\Broadcasting;

use App\Http\Resources\UserResource;
use App\Models\Room;
use App\Models\User;

class RoomChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function join(User $user, Room $room): bool|UserResource
    {
        if ($room->have($user)) {
            return new UserResource($user);
        }

        return false;
    }
}
