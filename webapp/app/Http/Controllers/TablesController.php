<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\City;
use App\Models\Table;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TablesController extends AdminController
{
    private TableRepositoryInterface $tableRepository;
    private TableTypeRepositoryInterface $tableTypeRepository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(TableRepositoryInterface     $tableRepository,
                                TableTypeRepositoryInterface $tableTypeRepository,
                                PlaceRepositoryInterface     $placeRepository,
                                LogServiceInterface          $logger)
    {
        parent::__construct($logger);

        $this->tableRepository = $tableRepository;
        $this->tableTypeRepository = $tableTypeRepository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        return view('tables/index');
    }

    public function detail($id)
    {
        $data = $this->tableRepository->find($id);
        $table_types = $this->tableTypeRepository->published();
        $places = $this->placeRepository->published();

        return view('tables/detail', ["data" => $data, "table_types" => $table_types, "places" => $places]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'display_order' => ['required', 'int'],
            ]);

            $db = $this->tableRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('tables/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Table();

                $db->name = $request->get('name');
                $db->minimum_spend = floatval($request->get('minimum_spend'));
                $db->guests_count = intval($request->get('guests_count'));
                $db->display_order = intval($request->get('display_order'));
                $db->table_type_id = $request->get('table_type_id');
                $db->place_id = $request->get('place_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->tableRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("tables");
    }

    public function delete($id)
    {
        $this->tableRepository->deleteLogic($id);
        return redirect("tables");
    }
}
