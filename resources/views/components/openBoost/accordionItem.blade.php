@props([
    'title' => $title ?? 'Accordion Item',
    'active' => $active ?? false,
])

<div
    data-openboost-accordion-item="true"
    data-openboost-accordion-item-active="{{ $active ? '1' : '0' }}"
    {{ $attributes->merge([
        'class' => 'openBoost-accordion-item',
    ]) }}
>
    <button
        type="button"
        data-openboost-accordion-trigger="true"
        {{ $attributes->merge([
            'class' => 'openBoost-accordion-trigger w-full text-left px-4 py-3 bg-gray-100 hover:bg-gray-200 border border-gray-300 font-semibold flex justify-between items-center',
        ]) }}
        aria-expanded="{{ $active ? 'true' : 'false' }}"
    >
        <span>{{ $title }}</span>
        <span class="openBoost-accordion-icon transition-transform duration-300">▼</span>
    </button>
    <div
        data-openboost-accordion-content="true"
        class="openBoost-accordion-content overflow-hidden transition-all duration-300 {{ $active ? 'block' : 'hidden' }}"
        role="region"
    >
        <div class="px-4 py-3 border border-t-0 border-gray-300 bg-white">
            {{ $slot }}
        </div>
    </div>
</div>
