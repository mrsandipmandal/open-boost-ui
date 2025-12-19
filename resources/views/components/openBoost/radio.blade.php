@props([
    'value' => $value ?? '',
    'label' => $label ?? '',
    'checked' => $checked ?? false,
])

<div class="form-check" data-openboost-radio="true">
    <input
        type="radio"
        class="form-check-input"
        value="{{ $value }}"
        id="{{ $value }}"
        data-openboost-radio-input="true"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes }}
    />
    <label class="form-check-label" for="{{ $value }}">
        {{ $label }}
    </label>
</div>
