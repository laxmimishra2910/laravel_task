<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Events\ProjectCreated;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

public function index(Request $request)
{
          if (!has_role('admin', 'hr')) {
        return view('unauthorized'); // Custom view with alert
    }
    

    if ($request->ajax()) {
        $projects = Project::with('employees')->select('projects.*');
        return DataTables::of($projects)
           ->addColumn('employees', function ($project) {
    $limit = 2;
    $employees = $project->employees;

    $shown = $employees->take($limit)->map(function ($e) {
        return '<span class="badge bg-info me-1 mb-1">' . $e->name . '</span>';
    });

    $hidden = $employees->slice($limit)->map(function ($e) {
        return '<span class="badge bg-secondary me-1 mb-1">' . $e->name . '</span>';
    });

    $html = $shown->implode(' ');

    if ($employees->count() > $limit) {
        $hiddenHtml = $hidden->implode(' ');
        $html .= <<<HTML
            <span class="show-more-toggle " style="cursor:pointer;">show more...</span>
            <div class="extra-employees d-none mt-2">{$hiddenHtml}</div>
        HTML;
    }

    return $html;
})
->rawColumns(['employees', 'actions'])

            ->addColumn('actions', function ($project) {
                $edit = '<a href="' . route('projects.edit', $project->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $delete = '
                    <form action="' . route('projects.destroy', $project->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button onclick="return confirm(\'Delete project?\')" class="btn btn-danger btn-sm">Delete</button>
                    </form>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['employees', 'actions'])
            ->make(true);
    }

    return view('projects.index');
}

    public function create() {
         $formFields = Config::get('form.project_form'); // this should match your config key
    return view('projects.create', compact('formFields'));
    }

 public function store(StoreProjectRequest $request)
{
    $project = Project::create($request->validated());
           
       
        event(new ProjectCreated($project));

        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    public function edit(Project $project) {
          $formFields = Config::get('form.project_form');
        return view('projects.edit', compact('project','formFields'));
    }

   

public function update(UpdateProjectRequest $request, Project $project)
{
    $project->fill($request->validated());

    if ($project->status === 'Completed' && !$project->end_date) {
        $project->end_date = now();
    }

    $project->save();

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

public function showFeedback($employeeId, $projectId)
{
    $employee = Employee::with(['projects' => function ($query) use ($projectId) {
        $query->where('projects.id', $projectId);
    }])->find($employeeId);

    $feedback = $employee->projects->first()->pivot->feedback ?? 'No feedback yet';

    return view('project.feedback', compact('feedback', 'employee'));
}


}
