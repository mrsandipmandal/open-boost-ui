@props([
    'id' => $id ?? 'openBoost-select-'.uniqid(),
    'multiple' => $multiple ?? false,
    'search' => $search ?? true,
    'lib' => $lib ?? 'select2',
    'theme' => $theme ?? 'bootstrap', // 'bootstrap' (default) or 'tailwind'
])

<select
    id="{{ $id }}"
    name="{{ $attributes->get('name') }}"
    {{ $multiple ? 'multiple' : '' }}
    data-openboost-select="true"
    data-openboost-select-lib="{{ $lib }}"
    data-openboost-select-search="{{ $search ? '1' : '0' }}"
    data-openboost-select-theme="{{ $theme === 'bootstrap' ? 'bootstrap-5' : '' }}"
    {{ $attributes->merge([
        'class' => trim('openBoost-select ' . ($theme === 'bootstrap' ? 'form-select w-full' : 'block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50')),
    ]) }}
>
    {{ $slot }}
</select>
