<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class CountriesController extends ApiController
{
    private CountryRepositoryInterface $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->countryRepository = $countryRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->countryRepository->published();
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->countryRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
