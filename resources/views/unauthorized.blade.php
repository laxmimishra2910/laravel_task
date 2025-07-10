<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Unauthorized
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto">
        <x-alert type="danger">
            🚫 You are not authorized to access this section.
        </x-alert>
    </div>
</x-app-layout>
