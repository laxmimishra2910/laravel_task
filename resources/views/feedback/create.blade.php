<x-app-layout>
    <x-slot name="header">
       
    </x-slot>
<div class="container">
   
<h1>{{ config('custom.default_feedback_message') ?? 'No message found' }}</h1>



    <h2>Submit Feedback</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf
        @include('feedback._form')
    </form>
</div>
</x-app-layout> 
