<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Http\JsonResponse;

class StatesController extends ApiController
{
    private StateRepositoryInterface $repository;

    public function __construct(StateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(): JsonResponse
    {
        return response()->json($this->repository->actives());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->repository->find($id));
    }
}
