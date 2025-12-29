<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlanList extends Component
{
    public $plans;
    /**
     * Create a new component instance.
     */
    public function __construct($plans)
    {
        $this->plans = $plans;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.plan-list');
    }
}
