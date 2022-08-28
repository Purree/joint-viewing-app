<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class OrderPolicy
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

    public function before(User $user, string $ability, string $class_name, Room $room)
    {
        if ($user->id === $room->owner_id) {
            return true;
        }
    }

    public function add(User $user, Room $room): bool
    {
        return Gate::allows('manipulate', [$room]);
    }

    public function delete(User $user, Room $room, Order $order): bool
    {
        return Gate::allows('manipulate', [$room]) || $order->customer->id === $user->id;
    }
}
