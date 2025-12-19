@props([
    'id' => $id ?? 'openBoost-toggle-'.uniqid(),
    'checked' => $checked ?? false,
    'label' => $label ?? '',
])

<div class="form-check form-switch" data-openboost-toggle="true">
    <input
        type="checkbox"
        id="{{ $id }}"
        class="form-check-input"
        data-openboost-toggle-input="true"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes }}
    />
    @if($label)
        <label class="form-check-label" for="{{ $id }}">
            {{ $label }}
        </label>
    @endif
</div>
