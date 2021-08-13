<?php

namespace App\Http\Controllers;

use App\AppModels\DatatableModel;
use App\Core\AppConstant;
use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\Service;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServicesController extends AdminController
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceTypeRepositoryInterface $serviceTypeRepository;
    private TenantRepositoryInterface $tenantRepository;

    public function __construct(ServiceRepositoryInterface     $serviceRepository,
                                ServiceTypeRepositoryInterface $serviceTypeRepository,
                                TenantRepositoryInterface      $tenantRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceRepository = $serviceRepository;
        $this->serviceTypeRepository = $serviceTypeRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function index()
    {
        return view('services/index');
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->serviceRepository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        if ($is_admin)
            $service_types = $this->serviceTypeRepository->actives();
        else
            $service_types = $this->serviceTypeRepository->activesByTenant(Auth::user()->tenant_id);

        $tenants = new Collection();

        if ($is_admin)
            $tenants = $this->tenantRepository->actives();

        return view('services/detail', [
            "data" => $data,
            "service_types" => $service_types,
            "tenants" => $tenants,
            "is_admin" => $is_admin
        ]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'display_order' => ['required', 'int'],
            ]);

            $db = $this->serviceRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('services/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new Service();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->service_type_id = $request->get('service_type_id');
                $db->place_id = 0;
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                if ($is_admin)
                    $db->tenant_id = intval($request->get('tenant_id'));

                $this->serviceRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("services");
    }

    public function delete($id)
    {
        $this->serviceRepository->deleteLogic($id);
        return redirect("services");
    }
}
