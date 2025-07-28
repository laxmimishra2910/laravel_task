<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;



class EmployeeController extends Controller
{
public function index(Request $request)
{

    
    if (!has_role('admin', 'hr')) {
        return view('unauthorized');
    }

    $employees = Employee::with('department')->get();
    

    if ($request->ajax()) {
        $employees = Employee::with('department'); // assuming relation: department

        return DataTables::of($employees)
            ->addColumn('photo', function ($row) {
                if ($row->photo) {
                    return '<img src="' . asset('storage/' . $row->photo) . '" class="w-10 h-10 rounded-full" />';
                }
                return '<span class="text-gray-400">No Photo</span>';
            })
            ->addColumn('department', function ($row) {
                return $row->department->name ?? 'N/A';
            })
                ->addColumn('status', function ($row) {
                if ($row->projects->isNotEmpty()) {
                    return '<span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Active</span>';
                } else {
                    return '<span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Inactive</span>';
                }
            })
            ->addColumn('actions', function ($row) {
                return '
                    <a href="' . route('employees.show', $row->id) . '" class="text-blue-500 mr-2">View</a>
                    <a href="' . route('employees.edit', $row->id) . '" class="text-green-500 mr-2">Edit</a>
                    <form action="' . route('employees.destroy', $row->id) . '" method="POST" class="inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="text-red-500" onclick="return confirm(\'Delete this employee?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['photo', 'status', 'actions']) // allow HTML rendering
            ->make(true);
    }

    // foreach ($employees as $employee) {
    //     $employee->pf = round($employee->salary * 0.12, 2);
    //     $employee->net_salary = round($employee->salary - $employee->pf, 2);
    // }

    $departments = Department::all();

    return view('employees.index', compact('employees', 'departments'));
}


    public function create()
    
    {
         $formFields = Config::get('form.employee_form');
    // return view('employees.create', compact('formFields'));
    
         $departments = Department::all();
        return view('employees.create', compact('departments','formFields'));
    }

    public function store(StoreEmployeeRequest $request)
{
    $validated = $request->validated();
     // Add tenant_id manually (assuming tenant_id is in the authenticated user)
   
// dd(Auth::user()->tenant_id);
    if ($request->hasFile('photo')) {
        $photopath = $request->file('photo')->store('employees', 'public');
        $validated['photo'] = $photopath;
    }

    $employee = Employee::create($validated);
    // dd($request->email, $employee);
      SendWelcomeEmailJob::dispatch($employee);

    return redirect()->route('employees.index')->with('message', 'Employee created. Email will be sent');
}

    public function show(string $id)
    {
    //      $employee = Employee::with(['department', 'projects'])->findOrFail($id);
    // return view('employees.show', compact('employee'));

        $employees=Employee::onlyTrashed()->get();
        return view('employees.trashed',compact('employees'));
    }

    public function edit(string $id)
    {
         $formFields = Config::get('form.employee_form');
        $employee=Employee::findOrFail($id);
        $departments = Department::all();
        return view('employees.edit',compact('employee','departments','formFields'));
    }
public function update(UpdateEmployeeRequest $request, string $id)
{
    $employee = Employee::findOrFail($id);
    $validated = $request->validated();

    if ($request->hasFile('photo')) {
        // Delete old photo
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        // Store new photo
        $photoPath = $request->file('photo')->store('employees', 'public');
        $validated['photo'] = $photoPath;
    }

    $employee->update($validated);

    return redirect()->route('employees.index')->with('success', 'Data updated successfully');
}



public function destroy(string $id)
    {
        $employee=Employee::findOrFail($id);
        $employee->delete();
         return redirect()->route('employees.index')->with('success', 'Data deleted successfully');

    }
public function trashed()
{
    $employees = Employee::onlyTrashed()->get();
    dd($employees); 
    // Check if any results come here
}



public function restore($id)
{
    $employee = Employee::withTrashed()->find($id);
    $employee->restore();

    return redirect()->route('employees.trashed')->with('success', 'Employee restored successfully');
}

public function forceDelete($id)
{
    $employee = Employee::withTrashed()->findOrFail($id);

    // Optionally delete image from storage
    if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
        Storage::disk('public')->delete($employee->photo);
    }

    $employee->forceDelete();

    return redirect()->route('employees.trashed')->with('success', 'Employee permanently deleted');
}
}