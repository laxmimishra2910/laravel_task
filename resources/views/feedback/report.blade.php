<x-app-layout>
    <x-slot name="header">
        
        
    </x-slot>
<div class="container">
    <h2><u>Feedback Summary</u></h2>
  <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Back</a>
    @if($report->count())
        <ul class="list-group mt-4">
            @foreach($report as $rating => $count)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $rating }}
                    <span class="badge bg-primary rounded-pill">{{ $count }} feedback(s)</span>
                </li>
            @endforeach
        </ul>
    @else
        <p>No feedback data to show.</p>
    @endif
</div>
</x-app-layout>
