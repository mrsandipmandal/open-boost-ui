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
    <ul
        role="tablist"
        data-openboost-tabs-list="true"
        class="openBoost-tabs-list nav nav-tabs"
    >
        {{ $slot }}
    </ul>
    <div class="tab-content">
        {{-- Tab panels will be rendered by tab component --}}
    </div>
</div>
