<?php


namespace App\Http\AdminApi;

use App\AppModels\DatatableModel;
use App\Core\AppConstant;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TablesController extends AdminApiController
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

    public function list(Request $request): JsonResponse
    {
        $is_admin = boolval($request->get('is_admin'));
        $tenant_id = intval($request->get('tenant_id'));

        $response = new DatatableModel();

        $draw = (int)$request->get('draw');
        $start = (int)$request->get('start');
        $length = (int)$request->get('length');
        $search_param = $request->get('search');
        $search = isset($search_param) && isset($search_param["value"]) ? $search_param["value"] : "";
        $order_by = 'name';

        try {
            if ($is_admin)
                $query = $this->tableRepository->activesPaged($start, $length, $order_by, $this->order(), $search);
            else
                $query = $this->tableRepository->activesPagedByTenant($tenant_id, $start, $length, $order_by, $this->order(), $search);

            foreach ($query["data"] as $item) {
                $item->place_name = AppConstant::getDash();
                $item->table_type_name = AppConstant::getDash();

                $place = $this->placeRepository->find($item->place_id);

                if (isset($place)) {
                    $item->place_name = $place->name;
                }

                $table_type = $this->tableTypeRepository->find($item->table_type_id);

                if (isset($table_type)) {
                    $item->table_type_name = $table_type->name;
                }
            }

            $count = $query["count"];

            if ($search != "")
                $count = $query["data"]->count();

            $response->setDraw($draw);
            $response->setRecordsFiltered($count);
            $response->setRecordsTotal($count);
            $response->setData($query["data"]);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
