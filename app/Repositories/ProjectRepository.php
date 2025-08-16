<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Employee;
use App\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAllForDataTable(Request $request)
    {
        $projects = Project::with('employees')->select('projects.*');

        return DataTables::of($projects)
            ->addColumn('checkbox', function ($project) {
                return '<input type="checkbox" class="row-checkbox" value="' . e($project->id) . '">';
            })
            ->addColumn('employees', function ($project) {
                $limit = 2;
                $employees = $project->employees;

                $shown = $employees->take($limit)->map(fn($e) =>
                    '<span class="badge bg-info me-1 mb-1">' . e($e->name) . '</span>'
                );

                $hidden = $employees->slice($limit)->map(fn($e) =>
                    '<span class="badge bg-secondary me-1 mb-1">' . e($e->name) . '</span>'
                );

                $html = $shown->implode(' ');

                if ($employees->count() > $limit) {
                    $html .= <<<HTML
                        <span class="show-more-toggle" style="cursor:pointer;">show more...</span>
                        <div class="extra-employees d-none mt-2">{$hidden->implode(' ')}</div>
                    HTML;
                }

                return $html;
            })
            ->addColumn('actions', function ($project) {
                $edit = '<a href="' . route('projects.edit', $project->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $delete = '
                    <form action="' . route('projects.destroy', $project->id) . '" method="POST" class="d-inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button onclick="return confirm(\'Delete project?\')" class="btn btn-danger btn-sm">Delete</button>
                    </form>';
                return $edit . ' ' . $delete;
            })
            ->editColumn('start_date', function ($project) {
                return Carbon::parse($project->start_date)->format('Y-m-d');
            })
            ->editColumn('end_date', function ($project) {
                return $project->end_date ? Carbon::parse($project->end_date)->format('Y-m-d') : '';
            })
            ->rawColumns(['checkbox', 'employees', 'actions'])
            ->make(true);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): bool
    {
        if (($data['status'] ?? null) === 'Completed' && !$project->end_date) {
            $project->end_date = now();
        }

        return $project->fill($data)->save();
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    public function getEmployeeProjects($userId)
    {
        return Project::whereHas('employees', function ($query) use ($userId) {
            $query->where('employee_id', $userId);
        })->get();
    }

    public function getEmployeeProjectFeedback($employeeId, $projectId)
    {
        $employee = Employee::with(['projects' => function ($query) use ($projectId) {
            $query->where('projects.id', $projectId);
        }])->find($employeeId);

        return $employee?->projects->first()?->pivot->feedback ?? 'No feedback yet';
    }
}
