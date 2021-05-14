<?php


namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    private $countryService;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    public function list(): JsonResponse
    {
        return response()->json($this->countryService->find(1));
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->countryService->find($id));
    }
}
