<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StoreComponent extends Component
{
    public $stores;
    /**
     * Create a new component instance.
     */
    public function __construct($stores)
    {
        $this->stores = $stores;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.store-component');
    }
}
