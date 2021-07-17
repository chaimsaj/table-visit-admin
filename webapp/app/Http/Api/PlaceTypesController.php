<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Repositories\PlaceTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PlaceTypesController extends ApiController
{
    private PlaceTypeRepositoryInterface $repository;

    public function __construct(PlaceTypeRepositoryInterface $repository)
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
