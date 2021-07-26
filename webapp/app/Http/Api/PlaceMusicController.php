<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class PlaceMusicController extends ApiController
{
    private PlaceMusicRepositoryInterface $placeMusicRepository;

    public function __construct(PlaceMusicRepositoryInterface $placeMusicRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->placeMusicRepository = $placeMusicRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeMusicRepository->published();
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
            $query = $this->placeMusicRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
