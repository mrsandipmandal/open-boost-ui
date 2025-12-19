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
    <div class="list-group" data-openboost-list-items="true">
        {{ $slot }}
    </div>

    <nav
        data-openboost-list-pagination="true"
        class="openBoost-list-pagination mt-4"
        aria-label="Pagination"
    >
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <button
                    type="button"
                    data-openboost-list-prev="true"
                    class="page-link"
                    aria-label="Previous page"
                >
                    Previous
                </button>
            </li>
            <div data-openboost-list-pages="true" class="pagination justify-content-center"></div>
            <li class="page-item">
                <button
                    type="button"
                    data-openboost-list-next="true"
                    class="page-link"
                    aria-label="Next page"
                >
                    Next
                </button>
            </li>
        </ul>
    </nav>
</div>
