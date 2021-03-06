<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\TableType;
use App\Repositories\TableTypeRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TableTypesController extends AdminController
{
    private TableTypeRepositoryInterface $tableTypeRepository;
    private TenantRepositoryInterface $tenantRepository;

    public function __construct(TableTypeRepositoryInterface $tableTypeRepository,
                                TenantRepositoryInterface    $tenantRepository,
                                LogServiceInterface          $logger)
    {
        parent::__construct($logger);

        $this->tableTypeRepository = $tableTypeRepository;
        $this->tenantRepository = $tenantRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $data = $this->tableTypeRepository->actives();
        else
            $data = $this->tableTypeRepository->activesByTenant(Auth::user()->tenant_id);

        return view('table-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $tenants = new Collection();

        if ($is_admin)
            $tenants = $this->tenantRepository->actives();

        $data = $this->tableTypeRepository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        return view('table-types/detail', [
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

            $db = $this->tableTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('table-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new TableType();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                if ($is_admin)
                    $db->tenant_id = intval($request->get('tenant_id'));

                $this->tableTypeRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("table-types");
    }

    public function delete($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->tableTypeRepository->find($id);

        if (isset($data) && ($is_admin || $data->tenant_id == Auth::user()->tenant_id))
            $this->tableTypeRepository->deleteLogic($id);

        return redirect("table-types");
    }
}
