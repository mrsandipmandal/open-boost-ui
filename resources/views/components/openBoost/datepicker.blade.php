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

@push('openBoostAssets')
    {!! \OpenBoost\UI\Services\AssetManager::getCSSFor($lib) !!}
@endpush

@push('openBoostScripts')
    {!! \OpenBoost\UI\Services\AssetManager::getJSFor($lib) !!}
@endpush

<input
    type="text"
    id="{{ $id }}"
    {{ $attributes->merge([
        'class' => 'openBoost-datepicker form-input',
        'data-openboost-datepicker' => true,
        'data-openboost-datepicker-lib' => $lib,
        'data-openboost-datepicker-mode' => $mode,
        'data-openboost-datepicker-time' => $enableTime ? '1' : '0',
    ]) }}
/>
