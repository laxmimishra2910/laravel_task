<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

      protected $model = \App\Models\Department::class;

    public function definition(): array
    {
        $itDepartments = [
            'Software Development',
            'IT Support',
            'Quality Assurance',
            'Network Engineering',
            'Cybersecurity',
            'DevOps',
            'Database Administration',
            'Cloud Engineering',
            'UI/UX Design',
            'Product Management'
        ];
        return [
               'name' => $this->faker->randomElement($itDepartments),
        ];
    }
}
