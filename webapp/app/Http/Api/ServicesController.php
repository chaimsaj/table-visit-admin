<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class ServicesController extends ApiController
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceRateRepositoryInterface $serviceRateRepository;
    private ServiceTypeRepositoryInterface $serviceTypeRepository;

    public function __construct(ServiceRepositoryInterface     $serviceRepository,
                                ServiceRateRepositoryInterface $serviceRateRepository,
                                ServiceTypeRepositoryInterface $serviceTypeRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceRepository = $serviceRepository;
        $this->serviceRateRepository = $serviceRateRepository;
        $this->serviceTypeRepository = $serviceTypeRepository;
    }

    public function rates($place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->serviceRateRepository->loadByPlace($place_id);

            foreach ($query as $item) {
                $service = $this->serviceRepository->find($item->service_id);

                if (isset($service)) {
                    $item->service_name = $service->name;
                    $item->service_type_id = $service->service_type_id;

                    $service_type = $this->serviceTypeRepository->find($service->service_type_id);

                    if (isset($service_type))
                        $item->service_type_name = $service_type->name;
                }
            }

            $response->setData($query);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
