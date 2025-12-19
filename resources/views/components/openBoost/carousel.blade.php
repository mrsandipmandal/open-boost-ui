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
        'class' => 'openBoost-carousel carousel slide',
    ]) }}
>
    @if ($showIndicators)
    <div
        data-openboost-carousel-indicators="true"
        class="openBoost-carousel-indicators carousel-indicators"
    >
    </div>
    @endif

    <div class="carousel-inner">
        {{ $slot }}
    </div>

    <button
        type="button"
        data-openboost-carousel-prev="true"
        class="carousel-control-prev"
        aria-label="Previous slide"
    >
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button
        type="button"
        data-openboost-carousel-next="true"
        class="carousel-control-next"
        aria-label="Next slide"
    >
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
        class="openBoost-carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded hover:bg-opacity-75 transition"
        aria-label="Next slide"
    >
        ❯
    </button>
</div>
