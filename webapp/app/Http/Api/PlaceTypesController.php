<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class PlaceTypesController extends ApiController
{
    private PlaceTypeRepositoryInterface $placeTypeRepository;

    public function __construct(PlaceTypeRepositoryInterface $placeTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->placeTypeRepository = $placeTypeRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeTypeRepository->published();
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
            $query = $this->placeTypeRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
