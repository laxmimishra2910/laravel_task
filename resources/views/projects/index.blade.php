<x-app-layout>

<div class="container">
    <h2><u>Projects</u></h2>
   @if(in_array(auth()->user()->role, ['admin', 'employee']))
    <a href="{{ route('projects.create') }}" class="btn btn-success mb-2">Create New Project</a>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
      @endif
    <table id='projectTable' >
        <thead>
            <tr>
               
                <th>Project Name</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                 <th>Employees</th> <!-- ✅ Added -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                 
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->start_date }}</td>
                <td>{{ $project->end_date }}</td>
                <td>
                @foreach($project->employees as $emp)
                    <span class="badge bg-info">{{ $emp->name }}</span>
                @endforeach
                </td>
                <td class="actions">
                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning  btn-sm ">Edit</a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete project?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- jQuery & DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#projectTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true
        });
    });
</script>

</x-app-layout>
