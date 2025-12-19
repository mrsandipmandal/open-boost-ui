@props([
    'label' => $label ?? 'Tab',
    'active' => $active ?? false,
])

<li class="nav-item" role="presentation">
    <button
        type="button"
        role="tab"
        data-openboost-tab-trigger="true"
        data-openboost-tab-active="{{ $active ? '1' : '0' }}"
        data-bs-toggle="tab"
        aria-selected="{{ $active ? 'true' : 'false' }}"
        {{ $attributes->merge([
            'class' => 'openBoost-tab-trigger nav-link ' . ($active ? 'active' : ''),
        ]) }}
    >
        {{ $label }}
    </button>
</li>

<div
    role="tabpanel"
    data-openboost-tab-panel="true"
    data-openboost-tab-active="{{ $active ? '1' : '0' }}"
    class="openBoost-tab-panel tab-pane {{ $active ? 'active show' : '' }}"
>
    {{ $slot }}
</div>
