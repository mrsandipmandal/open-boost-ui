<?php

namespace OpenBoost\UI\View\Components;

use Illuminate\View\Component;

class Editor extends Component
{
    public string $id;
    public string $name;
    public string $engine;

    public function __construct(
        string $id = null,
        string $name = 'content',
        string $engine = null
    ) {
        $this->id = $id ?? 'flash-editor-' . uniqid();
        $this->name = $name;
        $this->engine = $engine ?? config('flashjs.editor', 'quill');
    }

    public function render()
    {
        return view('flash::components.flash.editor');
    }
}
