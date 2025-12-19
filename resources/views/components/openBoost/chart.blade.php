@props([
    'id' => $id ?? 'openBoost-chart-'.uniqid(),
    'type' => $type ?? 'line',
    'engine' => $engine ?? config('openBoostjs.default_chart', 'chartjs'),
    'options' => $options ?? [],
    'data' => $data ?? [],
])

@php
    // Auto-require the chart engine when component is used
    \OpenBoost\UI\Services\AssetManager::require($engine === 'apexcharts' ? 'apexcharts' : 'chartjs');
@endphp

@push('openBoostAssets')
    {!! \OpenBoost\UI\Services\AssetManager::getCSSFor($engine === 'apexcharts' ? 'apexcharts' : 'chartjs') !!}
@endpush

@push('openBoostScripts')
    {!! \OpenBoost\UI\Services\AssetManager::getJSFor($engine === 'apexcharts' ? 'apexcharts' : 'chartjs') !!}
@endpush

<div
    data-openBoost-chart
    data-openBoost-chart-id="{{ $id }}"
    data-openBoost-chart-type="{{ $type }}"
    data-openBoost-chart-engine="{{ $engine }}"
    data-openBoost-chart-data='@json($data)'
    data-openBoost-chart-options='@json($options)'
>
    @if($engine === 'chartjs')
        <canvas id="{{ $id }}"></canvas>
    @else
        <div id="{{ $id }}"></div>
    @endif
</div>
