@props([
    'id' => $id ?? 'openBoost-list-'.uniqid(),
    'perPage' => $perPage ?? 10,
    'theme' => $theme ?? 'bootstrap',
])

<div
    id="{{ $id }}"
    data-openboost-list="true"
    data-openboost-list-perpage="{{ $perPage }}"
    data-openboost-list-theme="{{ $theme }}"
    {{ $attributes->merge([
        'class' => 'openBoost-list',
    ]) }}
>
    <ul
        data-openboost-list-items="true"
        class="openBoost-list-items space-y-2 mb-4"
    >
        {{ $slot }}
    </ul>

    <nav
        data-openboost-list-pagination="true"
        class="openBoost-list-pagination flex items-center justify-center gap-1 mt-4"
        aria-label="Pagination"
    >
        <button
            type="button"
            data-openboost-list-prev="true"
            class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            aria-label="Previous page"
        >
            Previous
        </button>
        <div data-openboost-list-pages="true" class="flex gap-1"></div>
        <button
            type="button"
            data-openboost-list-next="true"
            class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            aria-label="Next page"
        >
            Next
        </button>
    </nav>
</div>
