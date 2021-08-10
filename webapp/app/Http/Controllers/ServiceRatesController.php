<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRateRepository;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class ServiceRatesController extends AdminController
{
    private ServiceRateRepositoryInterface $serviceRateRepository;

    public function __construct(ServiceRateRepositoryInterface $serviceRateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->serviceRateRepository = $serviceRateRepository;
    }

    public function index()
    {
        return view('service-rates/index');
    }

    public function detail()
    {
        return view('service-rates/detail');
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
