<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Company;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           // ✅ Create a dummy company
        // $company = Company::create([
        //     'name' => 'Default Company',
            
        // ]);
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'position' => $this->faker->jobTitle,
            'salary' => $this->faker->randomFloat(2, 30000, 100000),
            'photo' => 'image/default.png', // ✅ Set a default image
             'department_id' => Department::factory(),
            //  'company_id' => $company?->id, // make sure the employee belongs to an existing company
        ];
    } 

    public function configure()
    {
        return $this->afterCreating(function ($employee) {
            $rolesByDepartment = [
                'Software Development' => ['Backend Developer', 'Frontend Developer', 'Full Stack Developer'],
                'IT Support' => ['Helpdesk Technician', 'Support Engineer'],
                'Quality Assurance' => ['QA Tester', 'Automation Engineer'],
                'Network Engineering' => ['Network Admin', 'Infrastructure Engineer'],
                'Cybersecurity' => ['Security Analyst', 'Penetration Tester'],
                'DevOps' => ['DevOps Engineer', 'CI/CD Specialist'],
                'Database Administration' => ['DBA', 'Database Analyst'],
                'Cloud Engineering' => ['Cloud Architect', 'Cloud Engineer'],
                'UI/UX Design' => ['UI Designer', 'UX Researcher'],
                'Product Management' => ['Product Owner', 'Product Manager']
            ];

            $departmentName = $employee->department->name ?? null;
            $positions = $rolesByDepartment[$departmentName] ?? ['Employee'];

            $employee->position = collect($positions)->random();
            $employee->save();
        });
    }
}
