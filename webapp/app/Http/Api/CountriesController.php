<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CountriesController extends ApiController
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
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
