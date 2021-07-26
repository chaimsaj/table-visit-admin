<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class PlaceFeaturesController extends ApiController
{
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;

    public function __construct(PlaceFeatureRepositoryInterface $placeFeatureRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->placeFeatureRepository = $placeFeatureRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeFeatureRepository->published();
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeFeatureRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
