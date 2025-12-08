<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public string $id;
    public bool $multiple;
    public bool $search;
    public string $lib;

    public function __construct(string $id = null, bool $multiple = false, bool $search = true, string $lib = 'select2')
    {
        $this->id = $id ?? 'openBoost-select-' . uniqid();
        $this->multiple = $multiple;
        $this->search = $search;
        $this->lib = $lib;
    }

    public function render()
    {
        return view('openBoost::components.openBoost.select');
    }
}
