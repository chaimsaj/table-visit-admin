<?php

namespace App\Http\Controllers;

use App\Core\LanguageEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\City;
use App\Models\PlaceDetail;
use App\Models\Table;
use App\Models\TableDetail;
use App\Models\TableRate;
use App\Models\UserToPlace;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableDetailRepositoryInterface;
use App\Repositories\TableRateRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TablesController extends AdminController
{
    private TableRepositoryInterface $tableRepository;
    private TableTypeRepositoryInterface $tableTypeRepository;
    private PlaceRepositoryInterface $placeRepository;
    private TableDetailRepositoryInterface $tableDetailRepository;
    private TableRateRepositoryInterface $tableRateRepository;

    public function __construct(TableRepositoryInterface       $tableRepository,
                                TableTypeRepositoryInterface   $tableTypeRepository,
                                PlaceRepositoryInterface       $placeRepository,
                                TableDetailRepositoryInterface $tableDetailRepository,
                                TableRateRepositoryInterface   $tableRateRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->tableRepository = $tableRepository;
        $this->tableTypeRepository = $tableTypeRepository;
        $this->placeRepository = $placeRepository;
        $this->tableDetailRepository = $tableDetailRepository;
        $this->tableRateRepository = $tableRateRepository;
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
        $table_detail = null;
        $table_rates = new Collection;

        if (isset($data)) {
            $table_detail = $this->tableDetailRepository->loadBy($id, LanguageEnum::English);
            $table_rates = $this->tableRateRepository->loadBy($id);
        }

        $tab = Session::get("tab", "data");

        return view('tables/detail',
            [
                "data" => $data,
                "table_types" => $table_types,
                "places" => $places,
                "table_detail" => $table_detail,
                "table_rates" => $table_rates,
                "tab" => $tab
            ]);
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

    public function save_details(Request $request, $id): RedirectResponse
    {
        try {
            $db = $this->tableDetailRepository->loadBy($id, LanguageEnum::English);

            if ($db == null)
                $db = new TableDetail();

            $db->name = "";
            $db->introduction = "";
            $db->detail = $request->get('table_detail');
            $db->table_id = $id;
            $db->language_id = LanguageEnum::English;
            $db->published = 1;

            $this->tableDetailRepository->save($db);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "details");

        return redirect()->back();
    }

    public function save_rate(Request $request, $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'table_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("table.save_rate error");
            } else {
                $table = $this->tableRepository->find($id);

                if (isset($table)) {
                    $db = new TableRate();

                    $db->rate = floatval($request->get('rate'));
                    $db->tax = 0;
                    $db->total_rate = floatval($request->get('rate'));
                    $db->valid_from = $request->get('valid_from');
                    $db->valid_to = $request->get('valid_to');
                    $db->table_id = $id;
                    $db->place_id = $table->place_id;
                    $db->show = $request->get('show') == "on";
                    $db->published = $request->get('published') == "on";

                    $this->tableRateRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "rates");

        return redirect()->back();
    }

    public function edit_rate(Request $request, $id): RedirectResponse
    {
        try {

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "rates");

        return redirect()->back();
    }

    public function delete_rate($id): RedirectResponse
    {
        $this->tableRateRepository->delete($id);

        Session::flash('tab', "rates");

        return redirect()->back();
    }
}
