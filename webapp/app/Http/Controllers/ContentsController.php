<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CoreController;
use Illuminate\Http\Request;

class ContentsController extends CoreController
{
    public function terms()
    {
        return view('contents/terms');
    }
}
