@props(['type' => 'info'])

@php
    $baseStyles = 'p-4 rounded-md border';
    $types = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'danger' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
@endphp

<div class="{{ $baseStyles }} {{ $types[$type] ?? $types['info'] }}">
    {{ $slot }}
</div>
