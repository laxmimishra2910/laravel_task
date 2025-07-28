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
            $employee->projects()->attach(
                $projects->random(2)->pluck('id')->toArray()
            );
        }
    }
    }
}
