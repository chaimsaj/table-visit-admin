<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Repositories\PolicyRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class PoliciesController extends AdminController
{
    private PolicyRepositoryInterface $repository;

    public function __construct(PolicyRepositoryInterface $repository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
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
