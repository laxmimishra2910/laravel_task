<?php

namespace App\Interfaces;

use App\Models\Project;
use Illuminate\Http\Request;

interface ProjectRepositoryInterface
{
    public function getAllForDataTable(Request $request);
    public function create(array $data): Project;
    public function update(Project $project, array $data): bool;
    public function delete(Project $project): bool;
    public function getEmployeeProjects($userId);
    public function getEmployeeProjectFeedback($employeeId, $projectId);
}
