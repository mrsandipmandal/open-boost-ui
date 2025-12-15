@props([
    'id' => $id ?? 'openBoost-accordion-'.uniqid(),
    'theme' => $theme ?? 'bootstrap',
    'allowMultiple' => $allowMultiple ?? false,
])

@php
    use OpenBoost\UI\Services\AssetManager;
@endphp

<div
    id="{{ $id }}"
    data-openboost-accordion="true"
    data-openboost-accordion-multiple="{{ $allowMultiple ? '1' : '0' }}"
    data-openboost-accordion-theme="{{ $theme }}"
    {{ $attributes->merge([
        'class' => 'openBoost-accordion',
        'role' => 'region',
    ]) }}
>
    {{ $slot }}
</div>

@php
    if (!defined('ACCORDION_ITEM_COUNT')) define('ACCORDION_ITEM_COUNT', 0);
@endphp
