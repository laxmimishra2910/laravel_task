<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'position' => $this->faker->jobTitle,
            'salary' => $this->faker->randomFloat(2, 30000, 100000),
            'photo' => 'image/default.png',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            // Create department if none exists
            $department = Department::inRandomOrder()->first() ?? Department::factory()->create();
            
            // Use syncWithoutDetaching to maintain the one-to-many constraint
            $employee->department()->sync([$department->id]);
        });
    }
}