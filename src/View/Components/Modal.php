<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public string $id;
    public string $title;

    public function __construct(string $id = null, string $title = 'Modal Title')
    {
        $this->id = $id ?? 'openBoost-modal-' . uniqid();
        $this->title = $title;
    }

    public function render()
    {
        return view('openBoost::components.openBoost.modal');
    }
}
