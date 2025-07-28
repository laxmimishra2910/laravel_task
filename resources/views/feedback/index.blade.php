<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-900 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Client Feedback</h2>

            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Back</a>
                <a href="{{ route('feedback.report') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Report</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="feedbackTable" class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Rating</th>
                          <th>Employee</th> {{-- New Column --}}
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    <!-- Loaded by DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    @vite('resources/js/feedback-datatable.js')
</x-app-layout>
