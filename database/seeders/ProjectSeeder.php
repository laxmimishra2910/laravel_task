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

        $projects = [
            ['Website Redesign', 'Revamping an outdated company website to improve UX/UI and SEO.'],
            ['Mobile App Development', 'Creating a cross-platform app using Flutter for an e-commerce platform.'],
            ['API Integration', 'Connecting third-party payment and shipping APIs into an existing ERP system.'],
            ['Machine Learning Model', 'Developing a predictive analytics tool for customer churn.'],
            ['Cloud Migration', 'Moving infrastructure from on-premises servers to AWS Cloud.'],
            ['DevOps Automation', 'Setting up CI/CD pipelines using GitHub Actions and Docker.'],
            ['Cybersecurity Audit', 'Auditing systems and implementing penetration testing for security hardening.'],
            ['Inventory System', 'Creating a Laravel-based inventory management system.'],
            ['CRM Enhancement', 'Adding analytics dashboards and lead-scoring features to the CRM.'],
            ['IoT Integration', 'Integrating smart devices using MQTT and real-time dashboards.'],
        ];

        foreach ($projects as $project) {
            DB::table('projects')->insert([
                'project_name' => $project[0],
                'description' => $project[1],
                'status' => $faker->randomElement(['Pending', 'In Progress', 'Completed']),
                'start_date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                'end_date' => $faker->boolean(50) ? $faker->dateTimeBetween('now', '+3 months')->format('Y-m-d') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}