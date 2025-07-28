<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;
use App\Models\Feedback;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Make sure CompanySeeder runs first
        $this->call([
            RoleSeeder::class,
            // CompanySeeder::class, // ⬅️ Add this before UserSeeder
            UserSeeder::class,
            ProjectSeeder::class,
        ]);

        Employee::factory()->count(500)->create();
        Feedback::factory()->count(500)->create();

        $this->call([
            EmployeeProjectSeeder::class,
        ]);
    }
}
