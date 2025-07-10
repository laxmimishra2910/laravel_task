<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statuses = ['Pending', 'In Progress', 'Completed'];

        for ($i = 1; $i <= 20; $i++) {
            $startDate = $faker->dateTimeBetween('-6 months', 'now');
            $endDate = $faker->boolean(70) ? $faker->dateTimeBetween($startDate, '+3 months') : null;

            DB::table('projects')->insert([
                'project_name' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement($statuses),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
