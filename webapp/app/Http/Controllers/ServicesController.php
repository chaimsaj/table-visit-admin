<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class ServicesController extends AdminController
{
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        return view('services/index');
    }

    public function detail()
    {
        return view('services/detail');
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
