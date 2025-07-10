<div class="form-wrapper">
@csrf
<div class="mb-3">
    <label>Name:</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Phone:</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Position:</label>
    <input type="text" name="position" class="form-control" value="{{ old('position', $employee->position ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Salary:</label>
    <input type="number" name="salary" class="form-control" step="0.01" value="{{ old('salary', $employee->salary ?? '') }}" required>
</div>
<div class="mb-3">
    <label>photo:</label>
    <input type="file" name="photo" class="form-control">
</div>
   <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
    </div>

</div>

{{-- Show preview if editing and image exists --}}
@if(!empty($employee->photo))
    <div class="mb-3">
        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Image" width="120" class="img-thumbnail">
    </div>
@endif



</div>