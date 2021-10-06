<?php


namespace App\Http\AdminApi;

use App\AppModels\DatatableModel;
use App\Core\AppConstant;
use App\Helpers\GoogleStorageHelper;
use App\Helpers\MediaHelper;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PlacesController extends AdminApiController
{
    private PlaceRepositoryInterface $placeRepository;
    private CityRepositoryInterface $cityRepository;
    private StateRepositoryInterface $stateRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository,
                                CityRepositoryInterface  $cityRepository,
                                StateRepositoryInterface $stateRepository,
                                LogServiceInterface      $logger)
    {
        parent::__construct($logger);

        $this->placeRepository = $placeRepository;
        $this->cityRepository = $cityRepository;
        $this->stateRepository = $stateRepository;
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

        switch ($this->orderColumn()) {
            case 0:
                $order_by = 'id';
                break;
            case 5:
                $order_by = 'display_order';
                break;
        }

        try {
            if ($is_admin)
                $query = $this->placeRepository->activesPaged($start, $length, $order_by, $this->order(), $search);
            else
                $query = $this->placeRepository->activesPagedByTenant($tenant_id, $start, $length, $order_by, $this->order(), $search);

            foreach ($query["data"] as $item) {
                $item->city_name = AppConstant::getDash();
                $item->state_name = AppConstant::getDash();

                $city = $this->cityRepository->find($item->city_id);

                if (isset($city)) {
                    $item->city_name = $city->name;

                    $state = $this->stateRepository->find($city->state_id);

                    if (isset($state))
                        $item->state_name = $state->name;
                }

                $item->image = MediaHelper::getImageUrl($item->image_path);
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
