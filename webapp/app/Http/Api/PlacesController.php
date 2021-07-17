<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CountryServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Http\JsonResponse;

class PlacesController extends ApiController
{
    private StateServiceInterface $service;

    public function __construct(StateServiceInterface $service)
    {
        $this->repository = $repository;
    }

    public function list(): JsonResponse
    {
        return response()->json($this->repository->all());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->repository->find($id));
    }
}
