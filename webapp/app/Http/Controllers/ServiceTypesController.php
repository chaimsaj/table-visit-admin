<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class ServiceTypesController extends AdminController
{
    private ServiceTypeRepositoryInterface $serviceTypeRepository;

    public function __construct(ServiceTypeRepositoryInterface $serviceTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->serviceTypeRepository = $serviceTypeRepository;
    }

    public function index()
    {
        return view('service-types/index');
    }

    public function detail()
    {
        return view('service-types/detail');
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
