<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CountryServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Http\JsonResponse;

class PlaceTypesController extends ApiController
{
    private StateServiceInterface $service;

    public function __construct(StateServiceInterface $service)
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
