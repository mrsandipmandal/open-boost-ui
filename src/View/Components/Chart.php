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
        $this->id = $id ?? 'openBoost-chart-' . uniqid();
        $this->type = $type;
        $this->engine = $engine ?? config('openBoostjs.default_chart', 'chartjs');
        $this->options = $options;
        $this->data = $data;
    }

    public function render()
    {
        return view('openBoost::components.openBoost.chart');
    }
}
