<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Repositories\PaymentRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class PaymentsController extends AdminController
{
    private PaymentRepositoryInterface $repository;

    public function __construct(PaymentRepositoryInterface $repository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
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
