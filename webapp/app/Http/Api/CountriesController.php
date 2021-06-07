<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;

class CountriesController extends ApiController
{
    private $countryService;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    public function list(): JsonResponse
    {
        try {
            return Datatables::of(User::all())->make(true);
        } catch (Throwable $ex) {
            return $ex;
        }

        //return response()->json($this->countryService->all());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->countryService->find($id));
    }
}
