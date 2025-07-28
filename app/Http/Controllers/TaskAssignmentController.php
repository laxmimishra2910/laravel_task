<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;

class TaskAssignmentController extends Controller
{
    /**
     * Show form to assign employees to a project.
     */
    public function create()
    {
        $projects = Project::all();
        $employees = Employee::all();

        return view('assignments.create', compact('projects', 'employees'));
    }

    /**
     * Handle the assignment submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'uuid|exists:employees,id',
        ]);

        $project = Project::findOrFail($request->project_id);

        // Optional: Handle roles and assigned_by if needed
        foreach ($request->employee_ids as $employeeId) {
            $project->employees()->attach($employeeId, [
                'assigned_at' => now(),
                // 'assigned_by' => auth()->id() ?? null, // optional
            ]);
        }

        return redirect()->back()->with('success', 'Employees assigned to project successfully.');
    }
}

