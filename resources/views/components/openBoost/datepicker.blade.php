@props([
    'id' => $id ?? 'openBoost-datepicker-'.uniqid(),
    'mode' => $mode ?? 'single',
    'enableTime' => $enableTime ?? false,
    'lib' => $lib ?? 'flatpickr',
])

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
