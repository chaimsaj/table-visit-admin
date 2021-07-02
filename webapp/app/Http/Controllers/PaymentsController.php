<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\LogServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class PaymentsController extends AdminController
{
    private UserServiceInterface $service;

    public function __construct(UserServiceInterface $service,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->service = $service;
    }

    public function index()
    {
        return view('payments/index');
    }

    public function detail()
    {
        return view('payments/detail');
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
