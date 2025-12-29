<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmailTemplatesList extends Component
{
    public $templates;
    /**
     * Create a new component instance.
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.email-templates-list');
    }
}
