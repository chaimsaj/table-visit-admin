<?php


namespace App\Http\AdminApi;


use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\AdminApi\Base\AdminApiController;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Http\JsonResponse;

class LocationsController extends AdminApiController
{
    private CountryServiceInterface $countryService;
    private StateServiceInterface $stateService;
    private CityServiceInterface $cityService;

    public function __construct(CountryServiceInterface $countryService,
                                StateServiceInterface $stateService,
                                CityServiceInterface $cityService)
    {
        $this->countryService = $countryService;
        $this->stateService = $stateService;
        $this->cityService = $cityService;
    }

    public function load_countries(): JsonResponse
    {
        return response()->json($this->countryService->actives());
    }

    public function load_states($country_id): JsonResponse
    {
        $response = new ApiModel();

        if ($country_id != 0)
            $response->setData($this->stateService->publishedByCountry($country_id));

        $response->setCode(ApiCodeEnum::Ok);

        return response()->json($response);
    }
}
