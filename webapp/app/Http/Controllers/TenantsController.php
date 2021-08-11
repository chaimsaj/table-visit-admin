<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class TenantsController extends AdminController
{
    private TenantRepositoryInterface $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);
        $this->tenantRepository = $tenantRepository;
    }

    public function index()
    {
        return view('tenants/index');
    }

    public function detail()
    {
        return view('tenants/detail');
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
