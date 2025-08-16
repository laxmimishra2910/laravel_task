<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Jobs\SendWelcomeEmailJob;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;


class EmployeeController extends Controller
{
    protected EmployeeRepositoryInterface $employeeRepo;

    public function __construct(EmployeeRepositoryInterface $employeeRepo)
    {
        $this->employeeRepo = $employeeRepo;
    }

    public function index(Request $request)
    {
        if (!has_role('admin', 'hr')) {
            return view('unauthorized');
        }

     if ($request->ajax()) {
        Log::debug('AJAX request received', $request->all());
        $response = $this->employeeRepo->getDataTable();
        Log::debug('Response data', json_decode($response->content(), true));
        return $response;
    }

        $employees = $this->employeeRepo->all();
        $departments = Department::all();
        return view('employees.index', compact('employees', 'departments'));
    }

 public function trashed(Request $request)
{
    if ($request->ajax()) {
        return $this->employeeRepo->getTrashedDataTable();
    }

    $employees = $this->employeeRepo->trashed();
    return view('employees.trashed', compact('employees'));
}



    public function create()
    {
        $formFields = config('form.employee_form');
        $departments = Department::all();
        return view('employees.create', compact('departments', 'formFields'));
    }

    public function show($id)
    {
        $employee = $this->employeeRepo->find($id);
        return view('employees.show', compact('employee'));
    }

  public function store(StoreEmployeeRequest $request)
{
    $validated = $request->validated();

    // Handle file upload
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('employees', 'public');
    }

    // Create employee
    $employee = Employee::create($validated);

    // Assign department if provided
    if ($request->has('department_id')) {
        $employee->assignToDepartment($request->department_id);
    }

    // Dispatch welcome email job
    SendWelcomeEmailJob::dispatch($employee);

    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
}

public function edit($id)
{
    $formFields = config('form.employee_form');
    $employee = $this->employeeRepo->find($id);
    
    // Get all departments for the dropdown
    $departments = Department::all(); // or Department::orderBy('name')->get();
    
    return view('employees.edit', compact('employee', 'departments', 'formFields'));
}
public function update(UpdateEmployeeRequest $request, $id)
{
    $validated = $request->validated();
    
    // Handle file upload
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('employees', 'public');
    }

    // Update basic employee fields
    $employee = $this->employeeRepo->update($id, $validated);
    
    // Handle department separately - this is the critical fix
    if ($request->has('department_id')) {
        $employee->department()->sync([$request->department_id]);
    }

    return redirect()->route('employees.index')->with('success', 'Employee updated.');
}
    public function destroy($id)
    {
        $this->employeeRepo->delete($id);
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }

    public function restore($id)
    {
        $this->employeeRepo->restore($id);
        return redirect()->route('employees.trashed')->with('success', 'Employee restored.');
    }

    public function forceDelete($id)
    {
        $this->employeeRepo->forceDelete($id);
        return redirect()->route('employees.trashed')->with('success', 'Employee permanently deleted.');
    }
}
