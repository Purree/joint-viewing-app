<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_closed = $this->faker->boolean();

        return [
            'name' => $this->faker->name(),
            'owner_id' => $this->faker->unique()->randomElement(User::pluck('id')->toArray()),
            'link' => $this->faker->slug(),
            'is_closed' => $is_closed,
            'is_private' => $this->faker->boolean(),
            'can_everyone_control' => $this->faker->boolean(),
            'password' => $is_closed ? Hash::make('password') : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Room $room) {
            $owner = User::whereId($room->owner_id)->first();
            $owner->current_room_id = $room->id;
            $owner->save();
        });
    }
}
