@props([
    'id' => $id ?? 'openBoost-editor-'.uniqid(),
    'name' => $name ?? 'content',
    'engine' => $engine ?? config('openBoostjs.editor', 'quill'),
])

@php
    // Auto-require the editor engine when component is used
    \OpenBoost\UI\Services\AssetManager::require($engine);
@endphp

@push('openBoostAssets')
    {!! \OpenBoost\UI\Services\AssetManager::getCSSFor($engine) !!}
@endpush

@push('openBoostScripts')
    {!! \OpenBoost\UI\Services\AssetManager::getJSFor($engine) !!}
@endpush

<div
    data-openBoost-editor
    data-openBoost-editor-id="{{ $id }}"
    data-openBoost-editor-engine="{{ $engine }}"
>
    <textarea id="{{ $id }}" name="{{ $name }}" class="hidden">{{ $slot }}</textarea>
    <div data-openBoost-editor-target></div>
</div>
