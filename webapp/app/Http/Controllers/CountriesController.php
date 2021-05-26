<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountriesController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;


    }

    public function index()
    {
        return view('countries/index');
    }

    public function detail()
    {
        return view('countries/detail');
    }

    public function data(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }
}
