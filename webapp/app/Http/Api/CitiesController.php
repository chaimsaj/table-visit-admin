<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\CityRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CitiesController extends ApiController
{
    private CityRepositoryInterface $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();

        $response->setData($this->repository->actives());
        $response->setCode(ApiCodeEnum::Ok);

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->repository->find($id));
    }
}
