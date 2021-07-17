<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRateRepository;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class ServiceRatesController extends AdminController
{
    private ServiceRateRepository $repository;

    public function __construct(ServiceRateRepository $repository,
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
