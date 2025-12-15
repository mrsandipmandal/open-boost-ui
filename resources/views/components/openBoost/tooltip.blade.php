@props([
    'id' => $id ?? 'openBoost-tooltip-'.uniqid(),
    'text' => $text ?? 'Tooltip',
    'position' => $position ?? 'top', // 'top', 'bottom', 'left', 'right'
])

<div
    id="{{ $id }}"
    data-openboost-tooltip="true"
    data-openboost-tooltip-position="{{ $position }}"
    data-openboost-tooltip-text="{{ $text }}"
    {{ $attributes->merge([
        'class' => 'openBoost-tooltip relative inline-block',
    ]) }}
>
    {{ $slot }}
    <div
        data-openboost-tooltip-content="true"
        class="openBoost-tooltip-content hidden absolute z-50 px-2 py-1 text-sm text-white bg-gray-800 rounded whitespace-nowrap pointer-events-none
            {{ $position === 'top' ? 'bottom-full left-1/2 transform -translate-x-1/2 mb-2' : '' }}
            {{ $position === 'bottom' ? 'top-full left-1/2 transform -translate-x-1/2 mt-2' : '' }}
            {{ $position === 'left' ? 'right-full top-1/2 transform -translate-y-1/2 mr-2' : '' }}
            {{ $position === 'right' ? 'left-full top-1/2 transform -translate-y-1/2 ml-2' : '' }}"
    >
        {{ $text }}
    </div>
</div>
