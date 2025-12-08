<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Chart extends Component
{
    public string $id;
    public string $type;
    public string $engine;
    public $options;
    public $data;

    public function __construct(
        string $id = null,
        string $type = 'line',
        string $engine = null,
        $options = [],
        $data = []
    ) {
        $this->id = $id ?? 'flash-chart-' . uniqid();
        $this->type = $type;
        $this->engine = $engine ?? config('flashjs.default_chart', 'chartjs');
        $this->options = $options;
        $this->data = $data;
    }

    public function render()
    {
        return view('flash::components.flash.chart');
    }
}
