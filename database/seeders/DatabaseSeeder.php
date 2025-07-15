<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use App\Models\Feedback;use Spatie\Permission\Models\Role;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
        RoleSeeder::class,
        UserSeeder::class,
        ProjectSeeder::class,
    ]);
   Tenant::factory()->count(3)->create()->each(function ($tenant) {
    app()->instance('tenant_id', $tenant->id); // ✅ bind manually
    Employee::factory()->count(10)->create();
});

    Feedback::factory()->count(500)->create();
    
    // ✅ Attach employees to projects
    $this->call([
        EmployeeProjectSeeder::class,
    ]);

 
    }
}
