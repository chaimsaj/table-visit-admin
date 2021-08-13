<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\ServiceType;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServiceTypesController extends AdminController
{
    private ServiceTypeRepositoryInterface $serviceTypeRepository;
    private TenantRepositoryInterface $tenantRepository;

    public function __construct(ServiceTypeRepositoryInterface $serviceTypeRepository,
                                TenantRepositoryInterface      $tenantRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceTypeRepository = $serviceTypeRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $data = $this->serviceTypeRepository->actives();
        else
            $data = $this->serviceTypeRepository->activesByTenant(Auth::user()->tenant_id);

        return view('service-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $tenants = new Collection();

        if ($is_admin)
            $tenants = $this->tenantRepository->actives();

        $data = $this->serviceTypeRepository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        return view('service-types/detail', [
            "data" => $data,
            "is_admin" => $is_admin,
            "tenants" => $tenants,
        ]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->serviceTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('service-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new ServiceType();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                if ($is_admin)
                    $db->tenant_id = intval($request->get('tenant_id'));

                $this->serviceTypeRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("service-types");
    }

    public function delete($id)
    {
        $this->serviceTypeRepository->deleteLogic($id);

        return redirect("service-types");
    }
}
