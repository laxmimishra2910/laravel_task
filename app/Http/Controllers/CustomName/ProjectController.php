<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Events\ProjectCreated;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Interfaces\ProjectRepositoryInterface;
use App\Jobs\MassUpdateProjectStatus;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ProjectController extends Controller
{
    protected $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function index(Request $request)
    {
        if (!has_role('admin', 'hr')) {
            return view('unauthorized');
        }

        if ($request->ajax()) {
            return $this->projectRepo->getAllForDataTable($request);
        }

        $module = 'project';
        $fields = collect(config("form.project_form", []))
            ->reject(function ($field) {
                return in_array($field['type'] ?? '', ['file', 'multiselect']) ||
                       ($field['name'] ?? '') === 'id';
            })
            ->values()
            ->toArray();

        return view('projects.index', [
            'module' => $module,
            'fields' => $fields,
            'statuses' => $this->getStatusOptions(),
        ]);
    }

    // Optional if you still want a simple table without employees
public function data(Request $request)
{
    if ($request->ajax()) {
        $projects = Project::with('employees')
            ->select(['id', 'project_name', 'status', 'start_date', 'end_date']);

        return DataTables::of($projects)
            ->addColumn('employees', function ($row) {
                return $row->employees->pluck('name')->join(', ');
            })
          ->addColumn('actions', function ($project) {
    $edit = '<a href="' . route('projects.edit', $project->id) . '" 
                class="text-yellow-500 hover:underline">Edit</a>';

    $delete = '<form action="' . route('projects.destroy', $project->id) . '" 
                method="POST" class="inline">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" 
                        class="text-red-500 hover:underline" 
                        onclick="return confirm(\'Delete project?\')">
                    Delete
                </button>
               </form>';

    return $edit . ' | ' . $delete;
})

            ->editColumn('start_date', function ($project) {
                return $project->start_date
                    ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d')
                    : '';
            })
            ->editColumn('end_date', function ($project) {
                return $project->end_date
                    ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d')
                    : '';
            })
            ->rawColumns(['employees', 'actions'])
            ->make(true);
    }
}



    protected function getStatusOptions()
    {
        return collect(config('form.project_form', []))
            ->firstWhere('name', 'status')['options'] ?? [];
    }

    public function create()
    {
        $formFields = config('form.project_form');
        return view('projects.create', compact('formFields'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectRepo->create($request->validated());

        event(new ProjectCreated($project));
        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    public function edit(Project $project)
    {
        $formFields = config('form.project_form');
        return view('projects.edit', compact('project', 'formFields'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->projectRepo->update($project, $request->validated());
        return redirect()->route('projects.index')->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $this->projectRepo->delete($project);
        return redirect()->route('projects.index')->with('success', 'Project deleted!');
    }

    public function show(Project $project)
    {
        return redirect()->route('projects.edit', $project);
    }

    public function employeeProjects()
    {
        $projects = $this->projectRepo->getEmployeeProjects(Auth::id());
        return view('projects.index', compact('projects'));
    }

    public function showFeedback($employeeId, $projectId)
    {
        $feedback = $this->projectRepo->getEmployeeProjectFeedback($employeeId, $projectId);
        $employee = \App\Models\Employee::find($employeeId);
        return view('project.feedback', compact('feedback', 'employee'));
    }

    public function massUpdate(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
            'column' => 'required|string|in:status,start_date,end_date',
            'value' => 'required|string',
        ]);

        $ids = explode(',', $request->selected_ids);

        MassUpdateProjectStatus::dispatch($ids, $request->column, $request->value);

        return response()->json([
            'message' => 'Mass update dispatched successfully',
            'success' => true
        ]);
    }
}
