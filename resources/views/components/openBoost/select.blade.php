@props([
    'id' => $id ?? 'openBoost-select-'.uniqid(),
    'multiple' => $multiple ?? false,
    'search' => $search ?? true,
    'lib' => $lib ?? 'select2',
    'theme' => $theme ?? 'bootstrap', // 'bootstrap' (default) or 'tailwind'
    'options' => [], // Array of options: ['value' => 'label']
])

@php
    use OpenBoost\UI\Services\AssetManager;
    AssetManager::isRequired($lib) || AssetManager::require($lib);
    
    // Build classes safely as string
    $selectClasses = 'openBoost-select ';
    if ($theme === 'bootstrap') {
        $selectClasses .= 'form-select w-full';
    } else {
        $selectClasses .= 'block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';
    }
@endphp

<select
    id="{{ $id }}"
    name="{{ $attributes->get('name') }}"
    {{ $multiple ? 'multiple' : '' }}
    data-openboost-select="true"
    data-openboost-select-lib="{{ $lib }}"
    data-openboost-select-search="{{ $search ? '1' : '0' }}"
    data-openboost-select-theme="{{ $theme === 'bootstrap' ? 'bootstrap-5' : '' }}"
    {{ $attributes->merge(['class' => $selectClasses]) }}
>
    @if (is_array($options) && count($options) > 0)
        @forelse($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @empty
        @endforelse
    @elseif ($slot->isNotEmpty())
        {!! $slot !!}
    @endif
</select>
