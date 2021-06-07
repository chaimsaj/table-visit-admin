<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CoreController;
use Illuminate\Http\Request;

class CitiesController extends CoreController
{
    public function index()
    {
        return view('cities/index');
    }

    public function detail()
    {
        return view('cities/detail');
    }

    public function save(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
