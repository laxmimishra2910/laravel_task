<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

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
