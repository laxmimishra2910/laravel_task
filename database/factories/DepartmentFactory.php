<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartmentFactory extends Factory
{
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
            'id' => (string) Str::uuid(),
            'name' => $this->faker->unique()->randomElement($itDepartments),
        ];
    }
}