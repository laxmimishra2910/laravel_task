<x-app-layout>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card employee-card shadow">
                <div class="row g-0">
                    <!-- Left Side: Photo -->
                    <div class="col-md-4 employee-photo-container text-center">
                        <img src="{{ $employee->photo ? asset($employee->photo) : 'https://via.placeholder.com/200' }}"
                             class="employee-photo"
                             alt="{{ $employee->name }}">
                    </div>

                    <!-- Right Side: Info -->
                    <div class="col-md-8 p-4">
                        <h3 class="text-primary">{{ $employee->name }}</h3>
                        <p class="text-muted mb-2">{{ $employee->position }}</p>

                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> {{ $employee->email }}</li>
                            <li><strong>Phone:</strong> {{ $employee->phone }}</li>
                            <li><strong>Salary:</strong> ₹{{ number_format($employee->salary, 2) }}</li>
                            <li><strong>Department:</strong> {{ $employee->department->name ?? 'N/A' }}</li>
                        </ul>

                        <a href="{{ route('employees.index') }}" class="btn btn-outline-primary mt-3">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</x-app-layout>