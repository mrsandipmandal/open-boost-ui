@props([
    'src' => $src ?? '',
    'alt' => $alt ?? 'Slide image',
    'active' => $active ?? false,
])

<div
    data-openboost-carousel-slide="true"
    {{ $attributes->merge([
        'class' => 'openBoost-carousel-slide carousel-item' . ($active ? ' active' : ''),
    ]) }}
>
    @if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="d-block w-100"
    />
    @else
    <div class="d-flex align-items-center justify-content-center bg-secondary" style="height: 400px;">
        {{ $slot }}
    </div>
    @endif
</div>
