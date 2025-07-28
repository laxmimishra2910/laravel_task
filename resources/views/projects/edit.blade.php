<x-app-layout>
    <x-slot name="header">
    
    </x-slot><div class="container">
    <h2>Edit Project</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
            @method('PUT') {{-- This tells Laravel it's a PUT request --}}

        @include('projects._form', ['data' => $project])

        
    </form>
</div>
</x-app-layout>
