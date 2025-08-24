document.addEventListener('DOMContentLoaded', function() {
    let table = $('#employeeTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $('#employeeTable').data('url'),
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="employee-checkbox" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'department', name: 'department.name' },
            { data: 'position', name: 'position' },
            { data: 'salary', name: 'salary' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search employees..."
        }
    });

    // Select All
    $('#selectAll').on('click', function() {
        $('.employee-checkbox').prop('checked', this.checked).trigger('change');
    });











    // Feedback Table (unchanged)
    $('#feedbackTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/feedback",
        columns: [
            { data: 'client_name', name: 'client_name' },
            { data: 'email', name: 'email' },
            { data: 'message', name: 'message' },
            { data: 'rating', name: 'rating' },
            { data: 'employee_name', name: 'employee.name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });


    // Projects Table
    const MAX_VISIBLE = 2; // show first 2 names, rest on click

    let projectTable = $('#projectTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#projectTable').data('url'),
            type: 'GET',
            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Failed to load project data.');
            }
        },
        columns: [
            { 
                data: null, 
                orderable: false, 
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="row-checkbox" value="${row.id}">`;
                }
            },
            { data: 'project_name', name: 'project_name' },
            { data: 'status', name: 'status' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },

            // ✅ Employees column with client-side "show more/less"
            { 
                data: 'employees',
                name: 'employees',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    // Accept array or comma-separated string
                    let names = Array.isArray(data)
                        ? data
                        : (typeof data === 'string' ? data.split(',').map(s => s.trim()).filter(Boolean) : []);

                    // For filtering/sorting, return plain text
                    if (type !== 'display') {
                        return names.join(', ');
                    }

                    if (!names.length) return '';

                    if (names.length <= MAX_VISIBLE) {
                        return names.join(', ');
                    }

                    const preview = names.slice(0, MAX_VISIBLE).join(', ');
                    const hidden = names.slice(MAX_VISIBLE).join(', ');
                    return `
                        <span class="names-preview">${preview}</span>
                        <span class="extra-employees hidden">, ${hidden}</span>
                        <button type="button" class="show-more-toggle underline ml-1">Show more...</button>
                    `;
                }
            },

            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // ✅ Delegated click (rows are dynamic) + Tailwind "hidden"
    $('#projectTable tbody').on('click', '.show-more-toggle', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const $extra = $btn.siblings('.extra-employees');
        const isHidden = $extra.hasClass('hidden');
        $extra.toggleClass('hidden', !isHidden);
        $btn.text(isHidden ? 'Show less' : 'Show more...');
    });

    // Select/Deselect All
    $('#selectAll').on('click', function () {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Mass Update (unchanged)
    $('#massUpdateBtn').on('click', function () {
        let ids = $('.row-checkbox:checked').map(function () { 
            return $(this).val(); 
        }).get();

        if (!ids.length) {
            alert('Please select at least one project.');
            return;
        }

        $('#selectedIdsInput').val(ids.join(','));
        $('#massUpdateModal').removeClass('hidden');
    });

    $('#closeMassModal').on('click', function () {
        $('#massUpdateModal').addClass('hidden');
    });

    $('#massColumn').on('change', function () {
        let field = '';
        if (this.value === 'status') {
            field = `
                <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Status</label>
                <select name="value" class="w-full border p-2 dark:bg-gray-700 dark:text-white">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            `;
        } else if (this.value === 'start_date' || this.value === 'end_date') {
            field = `
                <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Date</label>
                <input type="date" name="value" class="w-full border p-2 dark:bg-gray-700 dark:text-white">
            `;
        }
        $('#massValueField').html(field);
    });

    $('#massUpdateForm').on('submit', function (e) {
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize(), function (res) {
            alert(res.success);
            projectTable.ajax.reload();
            $('#massUpdateModal').addClass('hidden');
        }).fail(function (xhr) {
            console.error(xhr.responseText);
            alert('Mass update failed.');
        });
    });
});
$('#projectTable').on('click', '.show-more-toggle', function () {
    const $btn = $(this);
    const $extra = $btn.siblings('.extra-employees');

    if ($extra.hasClass('show')) {
        $extra.removeClass('show');
        setTimeout(() => $extra.addClass('d-none'), 400); // wait for animation
        $btn.text('Show more...');
    } else {
        $extra.removeClass('d-none');
        setTimeout(() => $extra.addClass('show'), 10); // small delay for animation trigger
        $btn.text('Show less');
    }
});
