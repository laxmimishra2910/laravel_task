<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // First create the profile
            $profile = Profile::create([
                'phone' => '1234567890',
                'address' => 'Some Address',
                'status' => 'unverified',
            ]);

            // Then create the pivot relationship
            DB::table('user_profile')->insert([
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}