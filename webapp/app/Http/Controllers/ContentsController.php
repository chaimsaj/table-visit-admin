<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentsController extends Controller
{
    public function terms()
    {
        return view('contents/terms');
    }
}
