<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;

class CitiesController extends ApiController
{
    private $service;

    public function __construct(CityServiceInterface $service)
    {
        $this->service = $service;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();

        $response->setData($this->service->all());
        $response->setCode(ApiCodeEnum::Ok);

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->service->find($id));
    }
}
