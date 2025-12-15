@props([
    'id' => $id ?? 'openBoost-tabs-'.uniqid(),
    'theme' => $theme ?? 'bootstrap',
])

<div
    id="{{ $id }}"
    data-openboost-tabs="true"
    data-openboost-tabs-theme="{{ $theme }}"
    {{ $attributes->merge([
        'class' => 'openBoost-tabs',
    ]) }}
>
    <div
        role="tablist"
        data-openboost-tabs-list="true"
        class="openBoost-tabs-list flex border-b border-gray-300 bg-gray-50"
    >
        {{ $slot }}
    </div>
</div>
