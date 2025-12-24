<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'profit' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
        ];
    }
}
