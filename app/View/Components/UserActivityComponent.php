<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserActivityComponent extends Component
{

    public $logs;
    /**
     * Create a new component instance.
     */
    public function __construct($logs)
    {
        $this->logs = $logs;
    }
   

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-activity-component');
    }
}
