<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CountryServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiController
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
