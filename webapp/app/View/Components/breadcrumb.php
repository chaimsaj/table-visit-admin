<?php

namespace App\View\Components;

use Illuminate\View\Component;

class breadcrumb extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.breadcrumb');
    }
}
