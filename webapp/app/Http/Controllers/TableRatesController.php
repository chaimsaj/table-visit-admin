<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\ServiceType;
use App\Repositories\TableRateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TableRatesController extends AdminController
{
    private TableRateRepositoryInterface $tableRateRepository;

    public function __construct(TableRateRepositoryInterface $tableRateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->tableRateRepository = $tableRateRepository;
    }

    public function index()
    {
        $data = $this->tableRateRepository->actives();
        return view('table-rates/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->tableRateRepository->find($id);
        return view('table-rates/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->tableRateRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('table-rates/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new ServiceType();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->tableRateRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("table-rates");
    }

    public function delete($id)
    {
        $this->serviceRateRepository->deleteLogic($id);

        return redirect("table-rates");
    }
}
