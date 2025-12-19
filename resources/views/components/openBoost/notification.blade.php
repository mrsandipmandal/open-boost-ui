@props([
    'id' => $id ?? 'openBoost-notification-'.uniqid(),
    'type' => $type ?? 'info', // 'success', 'error', 'warning', 'info'
    'dismissible' => $dismissible ?? true,
    'autoClose' => $autoClose ?? false,
    'closeDelay' => $closeDelay ?? 5000,
])

@php
    $alertType = match($type) {
        'success' => 'success',
        'error' => 'danger',
        'warning' => 'warning',
        default => 'info',
    };
@endphp

<div
    id="{{ $id }}"
    role="alert"
    data-openboost-notification="true"
    data-openboost-notification-type="{{ $type }}"
    data-openboost-notification-autoclose="{{ $autoClose ? '1' : '0' }}"
    data-openboost-notification-delay="{{ $closeDelay }}"
    {{ $attributes->merge([
        'class' => 'openBoost-notification alert alert-' . $alertType . ($dismissible ? ' alert-dismissible fade show' : ''),
    ]) }}
>
    {{ $slot }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
