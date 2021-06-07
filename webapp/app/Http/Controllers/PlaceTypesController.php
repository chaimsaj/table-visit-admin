<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class PlaceTypesController extends BasicController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('place-types/index');
    }

    public function detail()
    {
        return view('place-types/detail');
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
