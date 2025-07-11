<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Events\ProjectCreated;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
          if (!has_role('admin', 'hr')) {
        return view('unauthorized'); // Custom view with alert
    }
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create() {
        return view('projects.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'project_name' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
          
        $project = Project::create($validated);
        event(new ProjectCreated($project));

        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    public function edit(Project $project) {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project) {
    $validated = $request->validate([
        'project_name' => 'required|string',
        'description' => 'nullable|string',
        'status' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    $project->fill($validated); // Assign attributes

    // Optional: Add custom logic before saving
    if ($project->status === 'Completed' && !$project->end_date) {
        $project->end_date = now(); // Auto-complete end date if missing
    }

    $project->save(); // Save manually

    return redirect()->route('projects.index')->with('success', 'Project updated!');
}


    public function destroy(Project $project) {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted!');
    }

    public function employeeProjects()
{
      $user = Auth::user();
    
    $projects = Project::whereHas('employees', function ($query) use ($user) {
        $query->where('employee_id', $user->id);
    })->get();

    return view('projects.index', compact('projects'));
}

}
