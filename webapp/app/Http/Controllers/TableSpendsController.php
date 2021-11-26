<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\TableSpend;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableSpendRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TableSpendsController extends AdminController
{
    private TableSpendRepositoryInterface $repository;
    private TableRepositoryInterface $tableRepository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(TableSpendRepositoryInterface $repository,
                                TableRepositoryInterface      $tableRepository,
                                PlaceRepositoryInterface      $placeRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->tableRepository = $tableRepository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        $places = new Collection();

        if (Auth::check()) {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            if ($is_admin) {
                $places = $this->placeRepository->actives();
            } else {
                $tenant_id = 0;

                if (isset(Auth::user()->tenant_id))
                    $tenant_id = Auth::user()->tenant_id;

                $places = $this->placeRepository->activesByTenant($tenant_id);
            }
        }


        return view('table-spends/report', [
            "places" => $places,
            "date_from" => today()->format('m-d-Y'),
            "date_to" => today()->format('m-d-Y')
        ]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        return view('table-spends/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('table-spends/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new TableSpend();

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("table-spends");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("table-spends");
    }
}
