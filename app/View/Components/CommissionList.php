<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommissionList extends Component
{
    public $commissions;
    /**
     * Create a new component instance.
     */
    public function __construct($commissions)
    {
        $this->commissions = $commissions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.commission-list');
    }
}
