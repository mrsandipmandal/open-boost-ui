@props([
    'id' => $id ?? 'openBoost-editor-'.uniqid(),
    'name' => $name ?? 'content',
    'engine' => $engine ?? config('openBoostjs.editor', 'quill'),
])

<div
    data-openBoost-editor
    data-openBoost-editor-id="{{ $id }}"
    data-openBoost-editor-engine="{{ $engine }}"
>
    <textarea id="{{ $id }}" name="{{ $name }}" class="hidden">{{ $slot }}</textarea>
    <div data-openBoost-editor-target></div>
</div>
