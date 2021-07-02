<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\LogServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class PlaceDetailsController extends AdminController
{
    private $userService;

    public function __construct(UserServiceInterface $userService,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->userService = $userService;
    }

    public function index()
    {
        return view('places/index');
    }

    public function detail()
    {
        return view('places/detail');
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
