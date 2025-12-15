@props([
    'label' => $label ?? 'Tab',
    'active' => $active ?? false,
])

<button
    type="button"
    role="tab"
    data-openboost-tab-trigger="true"
    data-openboost-tab-active="{{ $active ? '1' : '0' }}"
    aria-selected="{{ $active ? 'true' : 'false' }}"
    {{ $attributes->merge([
        'class' => 'openBoost-tab-trigger px-4 py-2 font-medium border-b-2 transition-colors ' .
                   ($active ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900'),
    ]) }}
>
    {{ $label }}
</button>

<div
    role="tabpanel"
    data-openboost-tab-panel="true"
    data-openboost-tab-active="{{ $active ? '1' : '0' }}"
    class="openBoost-tab-panel {{ $active ? 'block' : 'hidden' }} p-4"
>
    {{ $slot }}
</div>
