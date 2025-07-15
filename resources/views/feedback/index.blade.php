<x-app-layout>
 
<div class="container">
    <h2><u>Client Feedback</u></h2>
   

</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<!-- 
   @if($feedbacks->count()) -->

<div class="flex gap-4  mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        Back
    </a>
    <a href="{{ route('feedback.report') }}" class="btn btn-warning">
        Report
    </a>
    
</div>

<div class="mt-4">
  <table id="feedbackTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Employee</th> <!-- ✅ New -->
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
            <tr>
                <td>{{ $feedback->employee->name ?? 'N/A' }}</td>
                <td>{{ $feedback->client_name }}</td>
                <td>{{ $feedback->email }}</td>
                <td>{{ $feedback->message }}</td>
                <td>{{ $feedback->rating }}</td>
                <td>{{ $feedback->created_at->format('Y-m-d') }}</td>
                <td class="d-flex">
                 
                    <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this feedback?')">Delete</button>
                        
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>No feedback available.</p>
    @endif
</div>
 <!-- Include jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"/>

    <script>
        $(function () {
            $('#feedbackTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('feedback.index') }}",
                columns: [
                    { data: 'employee_name', name: 'employee.name' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'email', name: 'email' },
                    { data: 'message', name: 'message' },
                    { data: 'rating', name: 'rating' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>

</x-app-layout>
