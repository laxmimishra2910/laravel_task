<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\Department;

class DashoardController extends Controller
{

public function index()
{
    $totalEmployees = Employee::count();
    $totalProjects = Project::count();
    $totalFeedback = Feedback::count();


    $departments = Department::withCount('employees')->get();
    $departmentNames = $departments->pluck('name');
    $employeeCounts = $departments->pluck('employees_count');

    $completionCount = Project::where('status', 'Completed')->count();
    $inProcessCount = Project::where('status', 'In Progress')->count();
    $assignedCount = Project::where('status', 'Pending')->count();


    $employees = Employee::latest()->take(5)->get();
    $projects = Project::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalEmployees',
        'totalProjects',
        'employees',
        'projects',
        'departmentNames',   // ✅ Add this
        'employeeCounts' ,    // ✅ And this
        'completionCount', 'inProcessCount', 'assignedCount' , // add for project status
        'totalFeedback', // ✅ Add this to the view
    ));
}
}