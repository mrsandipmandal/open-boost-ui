@props([
    'label' => $label ?? 'Dropdown',
    'placement' => $placement ?? 'bottom-start',
])

<div class="relative inline-block" data-openBoost-dropdown data-placement="{{ $placement }}">
    <button type="button" class="px-3 py-2 border rounded-md" data-openBoost-dropdown-toggle>
        {{ $label }}
    </button>

    <div class="hidden absolute mt-2 w-48 bg-white border rounded-md shadow-lg z-50"
         data-openBoost-dropdown-menu>
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
