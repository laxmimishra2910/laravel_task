<x-app-layout>
    <x-slot name="header">
        <!-- optional header content -->
    </x-slot>

    <div class="container mt-4">
        <h2><u>Add New Employee</u></h2>

        {{-- Show Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Starts --}}
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
          
     @include('employees._form', ['formFields' => $formFields])
        </form>
    </div>
</x-app-layout>
