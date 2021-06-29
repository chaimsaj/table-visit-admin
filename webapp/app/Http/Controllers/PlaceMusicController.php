<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class PlaceMusicController extends AdminController
{
    private $service;

    public function __construct(UserServiceInterface $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index()
    {
        return view('place-music/index');
    }

    public function detail()
    {
        return view('place-music/detail');
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
