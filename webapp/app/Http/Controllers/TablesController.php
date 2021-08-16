<?php

namespace App\Http\Controllers;

use App\Core\LanguageEnum;
use App\Core\UserTypeEnum;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TablesController extends AdminController
{
    private TableRepositoryInterface $tableRepository;
    private TableTypeRepositoryInterface $tableTypeRepository;
    private PlaceRepositoryInterface $placeRepository;
    private TableDetailRepositoryInterface $tableDetailRepository;

    public function __construct(TableRepositoryInterface       $tableRepository,
                                TableTypeRepositoryInterface   $tableTypeRepository,
                                PlaceRepositoryInterface       $placeRepository,
                                TableDetailRepositoryInterface $tableDetailRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->tableRepository = $tableRepository;
        $this->tableTypeRepository = $tableTypeRepository;
        $this->placeRepository = $placeRepository;
        $this->tableDetailRepository = $tableDetailRepository;
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

        if (isset($data)) {
            $table_detail = $this->tableDetailRepository->loadBy($id, LanguageEnum::English);
        }

        $tab = Session::get("tab", "data");

        return view('tables/detail',
            [
                "data" => $data,
                "table_types" => $table_types,
                "places" => $places,
                "table_detail" => $table_detail,
                "tab" => $tab
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

            $db = $this->tableRepository->find($id);

            if ($validator->fails() && $db == null) {

                $table_types = $this->tableTypeRepository->published();
                $places = $this->placeRepository->published();
                $table_detail = null;

                if (isset($data)) {
                    $table_detail = $this->tableDetailRepository->loadBy($id, LanguageEnum::English);
                }

                $tab = Session::get("tab", "data");

                return view('tables/detail', [
                    "data" => $request,
                    "table_types" => $table_types,
                    "places" => $places,
                    "table_detail" => $table_detail,
                    "tab" => $tab
                ])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new Table();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->minimum_spend = floatval($request->get('minimum_spend'));
                $db->guests_count = intval($request->get('guests_count'));
                $db->display_order = intval($request->get('display_order'));
                $db->table_type_id = $request->get('table_type_id');
                $db->place_id = $request->get('place_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                if ($is_admin) {
                    $place = $this->placeRepository->find($db->place_id);

                    if (isset($place))
                        $db->tenant_id = $place->tenant_id;
                }

                $this->tableRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("tables");
    }

    public function delete($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->tableRepository->find($id);

        if (isset($data) && ($is_admin || $data->tenant_id == Auth::user()->tenant_id))
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
}
