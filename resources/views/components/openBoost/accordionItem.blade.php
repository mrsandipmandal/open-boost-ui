@props([
    'title' => $title ?? 'Accordion Item',
    'active' => $active ?? false,
])

<div class="accordion-item" data-openboost-accordion-item="true" data-openboost-accordion-item-active="{{ $active ? '1' : '0' }}">
    <h2 class="accordion-header">
        <button
            type="button"
            class="accordion-button {{ $active ? '' : 'collapsed' }}"
            data-openboost-accordion-trigger="true"
            data-bs-toggle="collapse"
            aria-expanded="{{ $active ? 'true' : 'false' }}"
        >
            {{ $title }}
        </button>
    </h2>
    <div
        data-openboost-accordion-content="true"
        class="accordion-collapse collapse {{ $active ? 'show' : '' }}"
        role="region"
    >
        <div class="accordion-body">
            {{ $slot }}
        </div>
    </div>
</div>
