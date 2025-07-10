<x-app-layout>
    @if(session('success'))
    <x-alert type="success">
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="danger">
        {{ session('error') }}
    </x-alert>
<div class="container mt-4">
    <h2><u>Employee List</u></h2>
    
</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
      
<<div class="mt-4 flex flex-wrap gap-3 items-center">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        Back
    </a>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        Add New Employee
    </a>
    <a href="{{ route('employees.trashed') }}" class="btn btn-secondary">
        🗑️ View Trashed Employees
    </a>
</div>

<div class="mt-3">
    <!-- <table class="table table-bordered"> -->
        <table  id="employeeTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Salary</th>
                 <th>Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->phone }}</td>
                    <td>{{ $emp->position }}</td>
                   
                    <td>₹{{ number_format($emp->salary, 2) }}</td>
                    <td>
                     @if($emp->photo)
                        <img src="{{ asset('storage/' . $emp->photo) }}" alt="Employee Image" width="100" class="employee-photo">
                    @endif   
                    </td>
                    
                  <td class="actions">
                        <a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable();
    });
</script>


</x-app-layout>
