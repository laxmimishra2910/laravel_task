<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl">
      <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Employees</h2>

    <!-- Buttons group -->
    <div class="flex gap-3">
        <a href="{{ route('employees.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Add Employee
        </a>
                <div id="app">
    <employee-mass-update></employee-mass-update>
</div>
        <a href="{{ route('employees.trashed') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
            🗑️ View Trashed Employees
        </a>

    </div>
</div>



<div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow"  id="employeeTable" data-url="{{ route('employees.index') }}">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                       <th><input type="checkbox" id="selectAll"></th>
                        <th class="px-6 py-3">Photo</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Department</th>
                        <th class="px-6 py-3">Position</th>
                        <th class="px-6 py-3">Salary</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    @foreach ($employees as $emp)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                @if($emp->photo)
                                    <img src="{{ asset('storage/' . $emp->photo) }}"
                                         class="w-10 h-10 rounded-full object-cover" alt="Photo">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-xs text-white">N/A</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $emp->name }}</td>
                            <td class="px-6 py-4">{{ $emp->email }}</td>
                            <td class="px-6 py-4">{{ $emp->department->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                 @if ($emp->projects->isNotEmpty())
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Active
                </span>
            @else
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Inactive
                </span>
            @endif
                            </td>
                            <td >
                                <a href="{{ route('employees.show', $emp->id) }}" class="text-blue-500 hover:underline">View</a> |
                                <a href="{{ route('employees.edit', $emp->id) }}" class="text-yellow-500 hover:underline">Edit</a> |
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
      
</x-app-layout>
