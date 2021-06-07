<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\CoreController;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class CurrenciesController extends CoreController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('currencies/index');
    }

    public function detail()
    {
        return view('currencies/detail');
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
