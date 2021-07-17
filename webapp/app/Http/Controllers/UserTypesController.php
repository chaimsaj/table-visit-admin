<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use Illuminate\Http\Request;

class UserTypesController extends AdminController
{
    public function index()
    {
        return view('user-types/index');
    }

    public function detail()
    {
        return view('user-types/detail');
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
