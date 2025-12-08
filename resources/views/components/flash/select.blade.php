@props([
    'id' => $id ?? 'flash-select-'.uniqid(),
    'multiple' => $multiple ?? false,
    'search' => $search ?? true,
    'lib' => $lib ?? 'select2',
    'theme' => $theme ?? 'bootstrap', // 'bootstrap' (default) or 'tailwind'
])

<select
    id="{{ $id }}"
    name="{{ $attributes->get('name') }}"
    {{ $multiple ? 'multiple' : '' }}
    {{ $attributes->merge([
        'class' => trim('flash-select ' . ($theme === 'bootstrap' ? 'form-select w-full' : 'block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50')),
        'data-flash-select' => true,
        'data-flash-select-lib' => $lib,
        'data-flash-select-search' => $search ? '1' : '0',
        'data-flash-select-theme' => $theme === 'bootstrap' ? 'bootstrap-5' : '',
    ]) }}
>
    {{ $slot }}
</select>
