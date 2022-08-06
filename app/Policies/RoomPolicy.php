<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user, string $ability, Room $room)
    {
        if ($user->id === $room->owner_id) {
            return true;
        }
    }

    public function manage(User $user, Room $room): bool
    {
        return $user->id === $room->owner_id;
    }

    public function delete(User $user, Room $room): bool
    {
        return $this->manage($user, $room);
    }

    public function interact(User $user, Room $room): bool
    {
        return $room->members()->contains($user);
    }

    public function kick(User $user, Room $room): bool
    {
        return $this->manage($user, $room);
    }

    public function update(User $user, Room $room): bool
    {
        return $this->manage($user, $room);
    }
}
