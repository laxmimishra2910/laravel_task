<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class EmployeeRepository implements EmployeeRepositoryInterface
{
public function all()
{
    return Employee::with(['department' => function($query) {
        $query->select('departments.id', 'departments.name');
    }])->select('employees.*')->get();
}


    // In App\Repositories\EmployeeRepository

// public function paginate($perPage = 10)
// {
//     return Employee::with(['department' => function($query) {
//         $query->select('departments.id', 'departments.name');
//     }])->paginate($perPage);
// }
   public function trashed()
{
    return Employee::onlyTrashed()->with('department')->get(); // Fixed 'departmentp' to 'department'
}

   public function getDataTable()
{
   $query = Employee::with(['department:id,name', 'projects'])
    ->select('employees.*');

    return DataTables::eloquent($query)
        ->addColumn('photo', function($employee) {
            return $employee->photo 
                ? '<img src="'.asset('storage/'.$employee->photo).'" class="w-10 h-10 rounded-full"/>' 
                : '<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center"><span class="text-xs text-white">N/A</span></div>';
        })
        ->addColumn('department', function($employee) {
            return $employee->department ? $employee->department->name : 'N/A';
        })
        ->addColumn('status', function($employee) {
            if ($employee->trashed()) {
                return '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Trashed</span>';
            }
            return $employee->projects->isNotEmpty()
                ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">Active</span>'
                : '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full">Inactive</span>';
        })
        ->addColumn('actions', function($employee) {
            $actions = '<a href="'.route('employees.show', $employee->id).'" class="text-blue-500 ">View |</a>';

            if (!$employee->trashed()) {
                $actions .= '<a href="'.route('employees.edit', $employee->id).'" class="text-yellow-500">Edit |</a>';
                $actions .= '
                    <form action="'.route('employees.destroy', $employee->id).'" method="POST" class="inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="text-red-500" onclick="return confirm(\'Delete this employee?\')">Delete</button>
                    </form>
                ';
            } else {
                $actions .= '
                    <form action="'.route('employees.restore', $employee->id).'" method="POST" class="inline">
                        '.csrf_field().'
                        <button type="submit" class="text-green-500 mr-2" onclick="return confirm(\'Restore this employee?\')">Restore</button>
                    </form>
                    <form action="'.route('employees.forceDelete', $employee->id).'" method="POST" class="inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="text-red-500" onclick="return confirm(\'Permanently delete?\')">Force Delete</button>
                    </form>
                ';
            }

            return $actions;
        })
        ->rawColumns(['photo', 'status', 'actions'])
        ->toJson();
}

    public function getTrashedDataTable()
    {
        $query = Employee::onlyTrashed()->with(['department', 'projects']);

        return DataTables::eloquent($query)
            ->addColumn('photo', function($employee) {
                if ($employee->photo) {
                    return '<img src="'.asset('storage/'.$employee->photo).'" class="w-10 h-10 rounded-full"/>';
                }
                return 'No Photo';
            })
           // In EmployeeRepository's getDataTable() method
            ->addColumn('department', function($employee) {
                return optional($employee->department)->name ?? 'N/A';
            })
            ->addColumn('status', function($employee) {
                return '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Trashed</span>';
            })
            ->addColumn('actions', function($employee) {
                return '
                    <form action="'.route('employees.restore', $employee->id).'" method="POST" class="inline">
                        '.csrf_field().'
                        <button type="submit" class="text-green-500 mr-2" onclick="return confirm(\'Restore this employee?\')">Restore</button>
                    </form>
                    <form action="'.route('employees.forceDelete', $employee->id).'" method="POST" class="inline">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="text-red-500" onclick="return confirm(\'Permanently delete?\')">Force Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['photo', 'status', 'actions'])
            ->toJson();
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

public function find($id)
{
    return Employee::withTrashed()
        ->with(['department' => function($query) {
            $query->select(
                'departments.id as department_id',
                'departments.name',
                'department_employee.employee_id as pivot_employee_id',
                'department_employee.department_id as pivot_department_id',
                'department_employee.id as pivot_id'
            );
        }])
        ->findOrFail($id);
}
   public function update($id, array $data)
{
    $employee = $this->find($id);

    // Handle photo update
    if (isset($data['photo'])) {
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }
    }

    // Update only fillable fields - department_id should NOT be in $fillable
    $employee->update($data);
    
    return $employee;
}

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function restore($id)
    {
        return $this->find($id)->restore();
    }

    public function forceDelete($id)
    {
        $employee = $this->find($id);
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }
        return $employee->forceDelete();
    }
}