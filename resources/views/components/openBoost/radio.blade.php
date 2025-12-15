@props([
    'value' => $value ?? '',
    'label' => $label ?? '',
    'checked' => $checked ?? false,
])

<label
    data-openboost-radio="true"
    {{ $attributes->merge([
        'class' => 'openBoost-radio flex items-center cursor-pointer',
    ]) }}
>
    <input
        type="radio"
        value="{{ $value }}"
        data-openboost-radio-input="true"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge([
            'class' => 'openBoost-radio-input w-4 h-4 accent-blue-600',
        ]) }}
    />
    <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
</label>
