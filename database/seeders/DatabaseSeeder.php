<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First - Create essential system data
        $this->call([
            RoleSeeder::class, // Roles MUST come first
        ]);

        // Second - Create users and profiles
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
        ]);

        // Third - Create test data
        Department::factory()->count(10)->create();
        Employee::factory()->count(500)->create();

        $department = Department::first();
        Employee::factory()
            ->count(10)
            ->afterCreating(function ($employee) use ($department) {
                $employee->department()->sync([$department->id]);
            })
            ->create();

        // Create feedback and link to employees via pivot
        $feedbacks = Feedback::factory()->count(500)->create();
        $employeeIds = Employee::pluck('id')->toArray();

        foreach ($feedbacks as $feedback) {
            $assignedEmployees = collect($employeeIds)->random(rand(1, 2));

            foreach ($assignedEmployees as $employeeId) {
                DB::table('employee_feedback')->insert([
                    'id' => Str::uuid(),
                    'employee_id' => $employeeId,
                    'feedback_id' => $feedback->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->call([
            ProjectSeeder::class,
            EmployeeProjectSeeder::class,
        ]);
    }
}
