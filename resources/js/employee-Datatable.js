

$(document).ready(function () {
    let tableUrl = $('#employeeTable').data('url');

    $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: tableUrl,
        columns: [
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'department', name: 'department' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    $('#projectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/projects', // or use route('projects.index') via `@json()` if needed
        columns: [
            { data: 'project_name', name: 'project_name' },
            { data: 'status', name: 'status' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'employees', name: 'employees', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});
// Attach event listener after each draw
$('#projectTable').on('click', '.show-more-toggle', function () {
    const $row = $(this).closest('td');
    const $extra = $row.find('.extra-employees');

    if ($extra.hasClass('d-none')) {
        $extra.removeClass('d-none');
        $(this).text('Show less');
    } else {
        $extra.addClass('d-none');
        $(this).text('Show more....');
    }
});


//feedback//


    $('#feedbackTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/feedback",
        columns: [
            { data: 'client_name', name: 'client_name' },
            { data: 'email', name: 'email' },
            { data: 'message', name: 'message' },
            { data: 'rating', name: 'rating' },
               { data: 'employee_name', name: 'employee.name' }, // new
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });