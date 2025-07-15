<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Project;

class EmployeeProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
        $employees = Employee::all();
        $projects = Project::all();

          foreach ($employees as $employee) {
            if ($projects->count() > 0) {
                $randomProjects = $projects->shuffle()->take(min(2, $projects->count()))->pluck('id')->toArray();
                $employee->projects()->attach($randomProjects);
            }
        }
    }
    }
}
