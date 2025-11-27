<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletRequest>
 */
class WalletRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement(['deposit', 'withdrawal']),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
