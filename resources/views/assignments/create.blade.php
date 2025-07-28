<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assign Employees to Project
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded mt-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('assign.task.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Select Project:</label>
                <select name="project_id" class="w-full mt-1 border rounded p-2">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Select Employees:</label>
                <select name="employee_ids[]" class="w-full mt-1 border rounded p-2" multiple size="5">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->position }})</option>
                    @endforeach
                </select>
                <small class="text-gray-500">Hold Ctrl/Command to select multiple.</small>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Assign Task
            </button>
        </form>
    </div>
</x-app-layout>
