<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use Illuminate\Http\Request;

class CitiesController extends BasicController
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
