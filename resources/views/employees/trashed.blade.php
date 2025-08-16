<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Trashed Employees</h2>
            <div class="flex gap-3">
                <a href="{{ route('employees.index') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    ← Active Employees
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow" id="trashedTable">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <th class="px-6 py-3">Photo</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Department</th>
                        <th class="px-6 py-3">Deleted At</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    @forelse ($employees as $emp)
                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                @if($emp->photo)
                                    <img src="{{ asset('storage/' . ltrim($emp->photo, '/')) }}"
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
                            <td class="px-6 py-4">{{ $emp->deleted_at?->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                <a href="{{ route('employees.show', $emp->id) }}" class="text-blue-500 hover:underline">View</a>
                                <form action="{{ route('employees.restore', $emp->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline" onclick="return confirm('Restore this employee?')">Restore</button>
                                </form>
                                <form action="{{ route('employees.forceDelete', $emp->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Permanently delete?')">Force Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6">No trashed employees.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
