<?php

namespace Database\Seeders;

use App\Models\Employee;
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
        // User::factory(10)->create();

         $this->call([ UserSeeder::class,]);
        $this->call([ ProjectSeeder::class,]);

     Feedback::factory()->count(500)->create();
      Employee::factory()->count(500)->create();

 
    // Role::firstOrCreate(['name' => 'admin']);
    // Role::firstOrCreate(['name' => 'hr']);
    // Role::firstOrCreate(['name' => 'employee']);

    }
}
