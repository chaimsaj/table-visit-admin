<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountriesController extends BasicController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('countries/index');
    }

    public function detail()
    {
        return view('countries/detail');
    }

    public function save(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }
}
