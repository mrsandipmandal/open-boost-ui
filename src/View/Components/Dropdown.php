<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public string $label;
    public string $placement;

    public function __construct(string $label = 'Dropdown', string $placement = 'bottom-start')
    {
        $this->label = $label;
        $this->placement = $placement;
    }

    public function render()
    {
        return view('openBoost::components.openBoost.dropdown');
    }
}
