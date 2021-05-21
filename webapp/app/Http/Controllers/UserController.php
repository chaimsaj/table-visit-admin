<?php


namespace App\Http\Controllers;

use App\Services\UserServiceInterface;

class UserController extends Controller
{

    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->all();

        return view('users/index', ["data"=>$data]);
    }

    public function detail($id)
    {
        $data = $this->userService->find($id);

        return view('users/detail', ["data"=>$data]);

    }
}
