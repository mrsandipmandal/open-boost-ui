@props([
    'id' => $id ?? 'openBoost-datepicker-'.uniqid(),
    'mode' => $mode ?? 'single',
    'enableTime' => $enableTime ?? false,
    'lib' => $lib ?? 'flatpickr',
])

@php
    // Auto-require the library when component is used
    \OpenBoost\UI\Services\AssetManager::require($lib);
@endphp

<input
    type="text"
    id="{{ $id }}"
    {{ $attributes->merge([
        'class' => 'openBoost-datepicker form-input',
        'data-openBoost-datepicker' => true,
        'data-openBoost-datepicker-lib' => $lib,
        'data-openBoost-datepicker-mode' => $mode,
        'data-openBoost-datepicker-time' => $enableTime ? '1' : '0',
    ]) }}
/>
