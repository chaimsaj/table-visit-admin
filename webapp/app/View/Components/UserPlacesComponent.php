<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserPlacesComponent extends Component
{
    public function __construct()
    {

    }

    public function render()
    {
        return view('user.places');
    }
}
