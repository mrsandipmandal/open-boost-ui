@props([
    'id' => $id ?? 'openBoost-select-'.uniqid(),
    'multiple' => $multiple ?? false,
    'search' => $search ?? true,
    'lib' => $lib ?? 'select2',
    'theme' => $theme ?? 'bootstrap', // 'bootstrap' (default) or 'tailwind'
])

@php
    // Auto-require the library when component is used
    // \OpenBoost\UI\Services\AssetManager::require($lib);
@endphp
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
