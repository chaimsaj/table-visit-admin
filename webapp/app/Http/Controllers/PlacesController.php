<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        //
    }

    public function detail($id)
    {
        //
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