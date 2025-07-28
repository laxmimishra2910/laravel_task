<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Projects</h2>

            @if(in_array(auth()->user()->role, ['admin', 'employee']))
                <div class="flex gap-2">
                    <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Create New Project
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Back
                    </a>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table id="projectTable" class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow" data-url="{{ route('projects.index') }}">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <th class="px-6 py-3">Project Name</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Start Date</th>
                        <th class="px-6 py-3">End Date</th>
                        <th class="px-6 py-3">Employees</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    <!-- DataTables will populate this via Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
