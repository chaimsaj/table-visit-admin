<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\CityRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CitiesController extends ApiController
{
    private CityRepositoryInterface $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository,
                                LogServiceInterface $logger)
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

            $data = $request->json()->all();

            if (isset($data) && isset($data['word']))
                $word = $data['word'];

            if (strlen($word) >= 3) {
                $query = $this->cityRepository->search($word);
                $response->setData($query);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
