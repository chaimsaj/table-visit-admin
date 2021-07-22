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

    public function __construct(StateRepositoryInterface $stateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);
        $this->stateRepository = $stateRepository;
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
}
