@props([
    'src' => $src ?? '',
    'alt' => $alt ?? 'Slide image',
])

<div
    data-openboost-carousel-slide="true"
    {{ $attributes->merge([
        'class' => 'openBoost-carousel-slide w-full h-96 hidden',
    ]) }}
>
    @if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="w-full h-full object-cover"
    />
    @else
    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
        {{ $slot }}
    </div>
    @endif
</div>
