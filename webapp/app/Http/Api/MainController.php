<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Helpers\GoogleStorageHelper;
use App\Http\Api\Base\ApiController;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MainController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function health(): JsonResponse
    {
        $response = new ApiModel();
        $response->setData(now());
        $response->setTimestamp(now()->timestamp);
        $response->setCode(ApiCodeEnum::SUCCESS);
        return response()->json($response);
    }

    public function upload(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            GoogleStorageHelper::upload();
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
