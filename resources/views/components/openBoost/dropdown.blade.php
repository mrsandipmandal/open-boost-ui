@props([
    'label' => $label ?? 'Dropdown',
    'placement' => $placement ?? 'bottom-start',
])

<div class="dropdown d-inline-block" data-openBoost-dropdown data-placement="{{ $placement }}">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-openBoost-dropdown-toggle data-bs-toggle="dropdown" aria-expanded="false">
        {{ $label }}
    </button>

    <div class="dropdown-menu" data-openBoost-dropdown-menu>
        {{ $slot }}
    </div>
</div>
