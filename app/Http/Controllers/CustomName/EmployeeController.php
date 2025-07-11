<?php

namespace App\Http\Controllers\CustomName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Jobs\SendWelcomeEmailJob;



class EmployeeController extends Controller
{
    public function index()
    {
          if (!has_role('admin', 'hr')) {
        return view('unauthorized'); // Custom view with alert
    }
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    
    {
        return view('employees.create');
    }

    public function store(StoreEmployeeRequest $request)
{
    $validated = $request->validated();

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
        $employees=Employee::onlyTrashed()->get();
        return view('employees.trashed',compact('employees'));
    }

    public function edit(string $id)
    {
        
        $employee=Employee::findOrFail($id);
        return view('employees.edit',compact('employee'));
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