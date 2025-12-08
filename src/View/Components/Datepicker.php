<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Datepicker extends Component
{
    public string $id;
    public string $mode;
    public bool $enableTime;
    public string $lib;

    public function __construct(
        string $id = null,
        string $mode = 'single',
        bool $enableTime = false,
        string $lib = 'flatpickr'
    ) {
        $this->id = $id ?? 'openBoost-datepicker-' . uniqid();
        $this->mode = $mode;
        $this->enableTime = $enableTime;
        $this->lib = $lib;
    }

    public function render()
    {
        return view('openBoost::components.openBoost.datepicker');
    }
}
