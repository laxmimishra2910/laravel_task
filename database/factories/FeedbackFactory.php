<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name(),
            'email' => $this->faker->optional()->safeEmail(),
            'message' => $this->faker->paragraph(),
            'rating' => $this->faker->randomElement(['Excellent', 'Good', 'Average', 'Poor']),
        ];
    }
}
