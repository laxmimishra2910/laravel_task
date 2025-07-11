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
        @include('projects._form', ['project' => $project])
    </form>
</div>
</x-app-layout>
