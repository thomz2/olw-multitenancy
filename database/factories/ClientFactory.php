<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\RoleEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address_id' => fake()->numberBetween(1, 10),
            'user_id' => User::factory()->create(['role_id' => RoleEnum::CLIENT]),
            'role_id' => 4 // Ver se apago isso depois
        ];
    }
}
