<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    public function run(): void
    {
      

        // Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            
        ]);

        // HR user
       $hr= User::create([
            'name' => 'HR User',
            'email' => 'hr@example.com',
            'password' => Hash::make('hr123'),
            'role' => 'hr',
          
        ]);
  
    }
    
}
