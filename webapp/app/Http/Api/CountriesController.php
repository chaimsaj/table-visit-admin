<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;

class CountriesController extends ApiController
{
    private CountryServiceInterface $service;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->service = $countryService;
    }

    public function list(): JsonResponse
    {
        return response()->json($this->service->actives());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->service->find($id));
    }
}
