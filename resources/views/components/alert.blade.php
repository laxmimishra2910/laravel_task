@if($message)
    <div class="alert alert-{{ $type }} p-3 rounded shadow-sm">
        {{ $message }}
    </div>
@endif
