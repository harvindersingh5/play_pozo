<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class UserList extends Component
{
    public $users, $role;

    /**
     * Create a new component instance.
     */
    public function __construct($users, $role)
    {
        $this->users = $users;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.user-list');
    }
}

