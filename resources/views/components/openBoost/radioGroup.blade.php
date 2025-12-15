@props([
    'id' => $id ?? 'openBoost-radiogroup-'.uniqid(),
    'name' => $name ?? '',
    'direction' => $direction ?? 'vertical', // 'vertical' or 'horizontal'
])

<fieldset
    id="{{ $id }}"
    data-openboost-radiogroup="true"
    data-openboost-radiogroup-direction="{{ $direction }}"
    {{ $attributes->merge([
        'class' => 'openBoost-radiogroup',
    ]) }}
>
    <div class="{{ $direction === 'horizontal' ? 'flex gap-4' : 'space-y-2' }}">
        {{ $slot }}
    </div>
</fieldset>
