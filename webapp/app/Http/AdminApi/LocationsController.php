<?php


namespace App\Http\AdminApi;


use App\AppModels\ApiModel;
use App\AppModels\DatatableModel;
use App\Core\ApiCodeEnum;
use App\Core\AppConstant;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\DataTables;
use function PHPUnit\Framework\isEmpty;

class LocationsController extends AdminApiController
{
    private CountryRepositoryInterface $countryRepository;
    private StateRepositoryInterface $stateRepository;
    private CityRepositoryInterface $cityRepository;

    public function __construct(CountryRepositoryInterface $countryRepository,
                                StateRepositoryInterface $stateRepository,
                                CityRepositoryInterface $cityRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
    }

    public function load_states(int $country_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $states = $this->stateRepository->publishedByCountry($country_id);
            $response->setData($states);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function load_cities(int $state_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $cities = $this->cityRepository->publishedByState($state_id);
            $response->setData($cities);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function cities(Request $request): JsonResponse
    {
        $response = new DatatableModel();

        $draw = (int)$request->get('draw');
        $start = (int)$request->get('start');
        $length = (int)$request->get('length');
        $search_param = $request->get('search');
        $search = isset($search_param) && isset($search_param["value"]) ? $search_param["value"] : "";

        try {
            $query = $this->cityRepository->actives_paged($start, $length, $search);

            foreach ($query["data"] as $item) {
                $item->state_name = AppConstant::getDash();
                $item->country_name = AppConstant::getDash();

                $state = $this->stateRepository->find($item->state_id);

                if (isset($state)) {
                    $item->state_name = $state->name;

                    $country = $this->countryRepository->find($state->country_id);
                    if (isset($country))
                        $item->country_name = $country->name;
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
