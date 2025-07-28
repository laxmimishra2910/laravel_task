<x-app-layout>
    <x-slot name="header">
        
        
    </x-slot>
<div class="container">
    <h2><u>Create New Project</u></h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        @include('projects._form')
    </form>
   

</div>
</x-app-layout>
