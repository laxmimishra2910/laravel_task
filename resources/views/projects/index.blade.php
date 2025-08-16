<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Projects</h2>

            @if(in_array(auth()->user()->role, ['admin', 'employee']))
                <div class="flex gap-2">
                    <button id="massUpdateBtn" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Mass Update
                    </button>
                    <a href="{{ route('projects.create') }}" 
                       class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Create New Project
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Back
                    </a>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table id="projectTable" data-url="{{ route('projects.data') }}" 
                   class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <th class="px-6 py-3 w-10">
                            <input type="checkbox" id="selectAll" class="rounded">
                        </th>
                        <th class="px-6 py-3">Project Name</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Start Date</th>
                        <th class="px-6 py-3">End Date</th>
                        <th class="px-6 py-3">Employee</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Mass Update Modal -->
    <div id="massUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-[400px]">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Mass Update Selected Projects</h2>
            <form id="massUpdateForm" method="POST" action="{{ route('projects.mass-update') }}">
                @csrf
                <input type="hidden" name="selected_ids" id="selectedIdsInput">
                
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-300">Select Column</label>
                    <select name="column" id="massColumn" class="w-full border p-2 mb-4 dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Select Column --</option>
                        <option value="status">Status</option>
                        <option value="start_date">Start Date</option>
                        <option value="end_date">End Date</option>
                    </select>
                </div>

                <div id="massValueField" class="mb-4"></div>

                <div class="mt-4 flex justify-end">
                    <button type="button" id="closeMassModal" 
                            class="px-4 py-2 bg-gray-500 text-white rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Update Selected Projects
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
