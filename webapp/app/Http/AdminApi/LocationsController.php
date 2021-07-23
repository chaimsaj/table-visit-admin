<?php


namespace App\Http\AdminApi;


use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class LocationsController extends AdminApiController
{
    private StateRepositoryInterface $stateRepository;
    private CityRepositoryInterface $cityRepository;

    public function __construct(StateRepositoryInterface $stateRepository,
                                CityRepositoryInterface $cityRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);
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
            $states = $this->cityRepository->publishedByState($state_id);
            $response->setData($states);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
