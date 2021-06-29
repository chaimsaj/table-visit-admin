<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class BookingsController extends AdminController
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    public function index()
    {
        return view('bookings/index');
    }

    public function detail()
    {
        return view('bookings/detail');
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
