<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\TableType;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TableTypesController extends AdminController
{
    private TableTypeRepositoryInterface $tableTypeRepository;

    public function __construct(TableTypeRepositoryInterface $tableTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->tableTypeRepository = $tableTypeRepository;
    }

    public function index()
    {
        $data = $this->tableTypeRepository->actives();
        return view('table-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->tableTypeRepository->find($id);
        return view('table-types/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->tableTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('table-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new TableType();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->tableTypeRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("table-types");
    }

    public function delete($id)
    {
        $this->tableTypeRepository->deleteLogic($id);

        return redirect("table-types");
    }
}
