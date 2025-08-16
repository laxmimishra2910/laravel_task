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
    // Basic counts
    $totalEmployees = Employee::count();
    $totalProjects = Project::count();
    $totalFeedback = Feedback::count();

    // Department data - convert to array for max() function
    $departments = Department::withCount('employees')->get();
    $departmentNames = $departments->pluck('name')->toArray();
    $employeeCounts = $departments->pluck('employees_count')->toArray();

    // Project status data
    $completedProjects = Project::where('status', 'Completed')->count();
    $inProgressProjects = Project::where('status', 'In Process')->count();
    $pendingProjects = Project::where('status', 'Pending')->count();

    // Feedback data
    $feedbackRatings = [
        '5' => Feedback::where('rating', 5)->count(),
        '4' => Feedback::where('rating', 4)->count(),
        '3' => Feedback::where('rating', 3)->count(),
        '2' => Feedback::where('rating', 2)->count(),
        '1' => Feedback::where('rating', 1)->count(),
    ];

    // Calculate max employees for the view
$maxEmployees = !empty($employeeCounts) ? max($employeeCounts) : 0;

    $employees = Employee::with(['department', 'projects'])
                        ->latest()
                        ->take(5)
                        ->get();
    
    $projects = Project::latest()
                      ->take(5)
                      ->get();

    return view('dashboard', compact(
        'totalEmployees',
        'totalProjects',
        'totalFeedback',
        'departmentNames',
        'employeeCounts',
        'completedProjects',
        'inProgressProjects',
        'pendingProjects',
        'feedbackRatings',
        'maxEmployees',
        'employees',  
        'projects',   
    ));
}
}