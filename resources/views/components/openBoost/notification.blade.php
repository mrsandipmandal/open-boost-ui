@props([
    'id' => $id ?? 'openBoost-notification-'.uniqid(),
    'type' => $type ?? 'info', // 'success', 'error', 'warning', 'info'
    'dismissible' => $dismissible ?? true,
    'autoClose' => $autoClose ?? false,
    'closeDelay' => $closeDelay ?? 5000,
])

@php
    $bgColor = match($type) {
        'success' => 'bg-green-100 border-green-400 text-green-800',
        'error' => 'bg-red-100 border-red-400 text-red-800',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-800',
        default => 'bg-blue-100 border-blue-400 text-blue-800',
    };

    $icon = match($type) {
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        default => 'ℹ',
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
        'class' => 'openBoost-notification border-l-4 p-4 rounded mb-4 ' . $bgColor,
    ]) }}
>
    <div class="flex items-start justify-between">
        <div class="flex items-start gap-3">
            <span class="text-lg font-bold">{{ $icon }}</span>
            <div>
                {{ $slot }}
            </div>
        </div>
        @if ($dismissible)
        <button
            type="button"
            data-openboost-notification-close="true"
            aria-label="Close notification"
            class="openBoost-notification-close font-bold hover:opacity-70 transition"
        >
            ✕
        </button>
        @endif
    </div>
</div>
