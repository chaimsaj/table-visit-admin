<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;

class CityController extends ApiController
{
    private $service;

    public function __construct(CityServiceInterface $service)
    {
        $this->service = $service;
    }

    public function list(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->service->find($id));
    }
}
