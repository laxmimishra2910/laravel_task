<x-app-layout>
    <x-slot name="header">

        <div class="w-full flex justify-center mb-6">
            <nav class="flex flex-col md:flex-row gap-3 items-center">
                @if (session('error'))
                     <x-alert type="danger">
                         {{ session('error') }}
                     </x-alert>
                 @endif
                <a href="{{ route('employees.index') }}" class="btn btn-primary">
                    Manage Employees
                </a>
                <a href="{{ route('projects.index') }}" class="btn btn-success">
                    Manage Projects
                </a>
                <a href="{{ route('feedback.index') }}" class="btn btn-warning">
                    View Feedback
                </a>
            </nav>
        </div>
    </x-slot>

  
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
