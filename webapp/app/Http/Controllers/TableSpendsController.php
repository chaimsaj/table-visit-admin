<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\TableSpend;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableSpendRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TableSpendsController extends AdminController
{
    private TableSpendRepositoryInterface $repository;
    private TableRepositoryInterface $tableRepository;

    public function __construct(TableSpendRepositoryInterface $repository,
                                TableRepositoryInterface      $tableRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->tableRepository = $tableRepository;
    }

    public function index()
    {
        $data = $this->repository->actives();
        return view('table-spends/index', ["data" => $data]);
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
