<x-app-layout>
    

    <div class="py-8 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalEmployees }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active Projects</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalProjects }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Feedback</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalFeedback }}</p>
                </div>
            </div>

            {{-- Performance Overview --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Employees by Department</h3>
                    <p class="text-green-600 text-sm mb-2"></p>
                    <!-- Replace with chart -->
                    <div class="h-96 bg-gray-100 dark:bg-gray-700 rounded">
<canvas
    id="chart"
    data-labels='@json($departmentNames)'
    data-values='@json($employeeCounts)'
    width="400"
    height="400"
></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Project Completion Status</h3>
                    <p class="text-green-600 text-sm mb-2"></p>
                    <!-- Replace with chart -->
                    <div class="h-96 bg-gray-100 dark:bg-gray-700 rounded">
                
                 <canvas id="projectBarChart"></canvas>
<script>
    window.chartData = {
        completion: {{ $completionCount ?? 0 }},
        process: {{ $inProcessCount ?? 0 }},
        assigned: {{ $assignedCount ?? 0 }}
    };
</script>

                     
                    </div>
                </div>
            </div>

            {{-- Employees Table --}}
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Employees</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Name</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Department</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Status</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $employee->name }}</td>
                                    <td class="px-6 py-4 text-blue-500">{{ $employee->department->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                         @if ($employee->projects->isNotEmpty())
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Active
                </span>
            @else
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Inactive
                </span>
            @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('employees.show', $employee->id) }}" class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <a href="{{ route('employees.index') }}" class="text-blue-600 hover:underline">show more...</a>
            </div>

            {{-- Projects Table --}}
            <div class="bg-white dark:bg-gray-800 p-6 shadow rounded-2xl">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Projects</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Project Name</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Status</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Due Date</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach($projects as $project)
                                <tr>
                                    <td class="px-6 py-4 text-gray-800 dark:text-white">{{ $project->project_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $project->status == 'Completed' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-blue-500">{{ $project->end_date }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('employees.index') }}" class="text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                                 <a href="{{ route('projects.index') }}" class="text-blue-600 hover:underline">show more...</a>

            </div>

        </div>
    </div>
</x-app-layout>
