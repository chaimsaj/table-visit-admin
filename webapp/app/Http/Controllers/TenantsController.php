<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Tenant;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Throwable;

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
        $data = $this->tenantRepository->actives();
        return view('tenants/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->tenantRepository->find($id);
        return view('tenants/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->tenantRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('tenants/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new Tenant();
                    $db->tenant_uuid = strval(Uuid::uuid4());
                }

                $db->name = $request->get('name');
                $db->published = $request->get('published') == "on";

                $this->tenantRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("tenants");
    }

    public function delete($id)
    {
        $this->tenantRepository->deleteLogic($id);

        return redirect("tenants");
    }
}
