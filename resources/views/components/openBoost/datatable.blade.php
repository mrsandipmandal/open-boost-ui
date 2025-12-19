@props([
    'id' => $id ?? 'openBoost-datatable-'.uniqid(),
    'striped' => $striped ?? true,
    'hoverable' => $hoverable ?? true,
    'bordered' => $bordered ?? true,
])

<div
    id="{{ $id }}"
    data-openboost-datatable="true"
    data-openboost-datatable-striped="{{ $striped ? '1' : '0' }}"
    data-openboost-datatable-hoverable="{{ $hoverable ? '1' : '0' }}"
    {{ $attributes->merge([
        'class' => 'openBoost-datatable table-responsive',
    ]) }}
>
    <table
        class="table{{ $striped ? ' table-striped' : '' }}{{ $hoverable ? ' table-hover' : '' }}{{ $bordered ? ' table-bordered' : '' }}"
    >
        {{ $slot }}
    </table>
    <div
        data-openboost-datatable-pagination="true"
        class="openBoost-datatable-pagination d-flex justify-content-between align-items-center mt-3"
    >
        <div class="text-muted">
            <span data-openboost-datatable-info="true">Showing 1 to 10 of 0 entries</span>
        </div>
        <nav aria-label="Table pagination">
            <ul class="pagination" data-openboost-datatable-pages="true"></ul>
        </nav>
    </div>
</div>
