<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CmsPageList extends Component
{

    public $cmsPages;
    /**
     * Create a new component instance.
     */
    public function __construct($cmsPages)
    {
        $this->cmsPages = $cmsPages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cms-page-list');
    }
}
