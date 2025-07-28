<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use App\Models\Company;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first company (e.g., Tech Corp)
        // $company = Company::first();

        // Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            // 'company_id' => $company->id, // ✅ Assign company
        ]);

        // HR user
        User::create([
            'name' => 'HR User',
            'email' => 'hr@example.com',
            'password' => Hash::make('hr123'),
            'role' => 'hr',
            // 'company_id' => $company->id, // ✅ Assign company
        ]);
    }
}
