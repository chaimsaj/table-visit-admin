<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\LanguageEnum;
use App\Core\PolicyTypeEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\PolicyRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PoliciesController extends ApiController
{
    private PolicyRepositoryInterface $policyRepository;

    public function __construct(PolicyRepositoryInterface $policyRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);

        $this->policyRepository = $policyRepository;
    }

    public function list($place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $language = LanguageEnum::English;
            $policies = new Collection;

            $place_reservation_policy = $this->policyRepository->loadBy($place_id, PolicyTypeEnum::Reservation, $language);

            if (isset($place_reservation_policy))
                $policies->add($place_reservation_policy);

            $place_cancellation_policy = $this->policyRepository->loadBy($place_id, PolicyTypeEnum::Cancellation, $language);

            if (isset($place_cancellation_policy))
                $policies->add($place_cancellation_policy);

            $response->setData($policies);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function load_by_type($place_id, $policy_type): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $language = LanguageEnum::English;
            $query = $this->policyRepository->loadBy($place_id, $policy_type, $language);

            if (isset($query))
                $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
