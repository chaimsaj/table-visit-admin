<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use Illuminate\Http\Request;

class ContentsController extends BasicController
{
    public function terms()
    {
        return view('contents/terms');
    }

    public function lockScreen()
    {
        return view('contents/lock-screen');
    }
}
