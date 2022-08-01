<?php

namespace Database\Factories;

use App\Models\User;
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
        $owner = User::inRandomOrder()->first()->id;
        $owner->current_room = $this->id;
        $owner->save();

        return [
            'name' => $this->faker->name(),
            'owner_id' => $owner,
            'link' => $this->faker->asciify('*********'),
            'is_closed' => $is_closed,
            'is_private' => $this->faker->boolean(),
            'everyone_control' => $this->faker->boolean(),
            'password' => $is_closed ? $this->faker->password() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
