<x-app-layout>
    <x-slot name="header">
       
        
    </x-slot>
<div class="container mt-4">
    <h2>Trashed Employees</h2>
    <p>Total Trashed: {{ $employees->count() }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('employees.index') }}" class="btn btn-secondary mb-3">← Back to Active Employees</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->position }}</td>
                    <td>
                        <form action="{{ route('employees.restore', $emp->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button class="btn btn-sm btn-success">Restore</button>
                        </form>

                        <form action="{{ route('employees.forceDelete', $emp->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Permanently delete this employee?')">Delete Forever</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No trashed employees found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
