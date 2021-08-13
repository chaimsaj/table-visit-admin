<?php


namespace App\Http\AdminApi;


use App\AppModels\ApiModel;
use App\AppModels\DatatableModel;
use App\Core\ApiCodeEnum;
use App\Core\AppConstant;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\DataTables;
use function PHPUnit\Framework\isEmpty;

class TablesController extends AdminApiController
{
    private TableRepositoryInterface $tableRepository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(TableRepositoryInterface $tableRepository,
                                PlaceRepositoryInterface $placeRepository,
                                LogServiceInterface      $logger)
    {
        parent::__construct($logger);
        $this->tableRepository = $tableRepository;
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

        try {
            if ($is_admin)
                $query = $this->tableRepository->activesPaged($start, $length, $search);
            else
                $query = $this->tableRepository->activesPagedByTenant($tenant_id, $start, $length, $search);

            foreach ($query["data"] as $item) {
                $item->place_name = AppConstant::getDash();

                $place = $this->placeRepository->find($item->place_id);

                if (isset($place)) {
                    $item->place_name = $place->name;
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
