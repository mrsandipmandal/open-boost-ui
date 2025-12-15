@props([
    'id' => $id ?? 'openBoost-toggle-'.uniqid(),
    'checked' => $checked ?? false,
    'label' => $label ?? '',
])

<label
    for="{{ $id }}"
    data-openboost-toggle="true"
    {{ $attributes->merge([
        'class' => 'openBoost-toggle flex items-center cursor-pointer gap-3',
    ]) }}
>
    <div class="relative inline-block w-12 h-6">
        <input
            type="checkbox"
            id="{{ $id }}"
            data-openboost-toggle-input="true"
            {{ $checked ? 'checked' : '' }}
            class="openBoost-toggle-input opacity-0 w-0 h-0"
        />
        <div
            data-openboost-toggle-track="true"
            class="openBoost-toggle-track absolute cursor-pointer top-0 left-0 right-0 bottom-0 bg-gray-300 rounded-full transition-colors duration-300"
        ></div>
        <div
            data-openboost-toggle-thumb="true"
            class="openBoost-toggle-thumb absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-300"
        ></div>
    </div>
    @if ($label)
    <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
    @endif
</label>
