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
        'class' => 'openBoost-datatable w-full overflow-x-auto',
    ]) }}
>
    <table
        class="w-full text-sm
            {{ $striped ? 'stripe' : '' }}
            {{ $hoverable ? 'hover' : '' }}
            {{ $bordered ? 'border border-gray-300' : '' }}"
    >
        {{ $slot }}
    </table>
    <div
        data-openboost-datatable-pagination="true"
        class="openBoost-datatable-pagination flex items-center justify-between mt-4 gap-2"
    >
        <div class="text-sm text-gray-600">
            <span data-openboost-datatable-info="true">Showing 1 to 10 of 0 entries</span>
        </div>
        <div class="flex gap-1">
        </div>
    </div>
</div>
