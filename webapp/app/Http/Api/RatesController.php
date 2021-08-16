<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class RatesController extends ApiController
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceRateRepositoryInterface $serviceRateRepository;

    public function __construct(ServiceRepositoryInterface     $serviceRepository,
                                ServiceRateRepositoryInterface $serviceRateRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceRepository = $serviceRepository;
        $this->serviceRateRepository = $serviceRateRepository;
    }

    public function rates($service_id, $place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->serviceRepository->loadByPlace($place_id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
