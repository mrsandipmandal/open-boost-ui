@props([
    'value' => $value ?? '',
])

<li
    data-openboost-list-item="true"
    {{ $attributes->merge([
        'class' => 'openBoost-list-item px-4 py-2 border border-gray-300 rounded hover:bg-gray-50 cursor-pointer transition',
    ]) }}
>
    {{ $slot ?? $value }}
</li>
