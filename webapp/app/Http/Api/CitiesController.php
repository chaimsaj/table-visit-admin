<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use App\Http\Requests\Cities\Cities_near_request;
use App\Repositories\CityRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CitiesController extends ApiController
{
    private CityRepositoryInterface $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository,
                                LogServiceInterface     $logger)
    {
        parent::__construct($logger);

        $this->cityRepository = $cityRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->cityRepository->published();
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function find(int $id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->cityRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function search(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $word = "";

            $request_data = $request->json()->all();

            if (isset($request_data) && isset($request_data['word']))
                $word = $request_data['word'];

            $query = $this->cityRepository->search($word);

            $response->setData($query);

            /*if (strlen($word) >= 3) {
            }*/
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function top(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->cityRepository->top();
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function near(Cities_near_request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $lat = $request->input('latitude');
        $lon = $request->input('longitude');
        $distance = $request->has('distance') ? $request->input('distance') : 10;
        try {
            $query = $this->cityRepository->near($lat,$lon,$distance);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    
}
