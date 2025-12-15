@props([
    'id' => $id ?? 'openBoost-carousel-'.uniqid(),
    'autoPlay' => $autoPlay ?? false,
    'interval' => $interval ?? 5000,
    'showIndicators' => $showIndicators ?? true,
])

<div
    id="{{ $id }}"
    data-openboost-carousel="true"
    data-openboost-carousel-autoplay="{{ $autoPlay ? '1' : '0' }}"
    data-openboost-carousel-interval="{{ $interval }}"
    data-openboost-carousel-indicators="{{ $showIndicators ? '1' : '0' }}"
    {{ $attributes->merge([
        'class' => 'openBoost-carousel relative w-full overflow-hidden rounded-lg shadow-lg',
    ]) }}
>
    <div class="openBoost-carousel-slides relative w-full">
        {{ $slot }}
    </div>

    @if ($showIndicators)
    <div
        data-openboost-carousel-indicators="true"
        class="openBoost-carousel-indicators absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2"
    >
    </div>
    @endif

    <button
        type="button"
        data-openboost-carousel-prev="true"
        class="openBoost-carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded hover:bg-opacity-75 transition"
        aria-label="Previous slide"
    >
        ❮
    </button>
    <button
        type="button"
        data-openboost-carousel-next="true"
        class="openBoost-carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded hover:bg-opacity-75 transition"
        aria-label="Next slide"
    >
        ❯
    </button>
</div>
