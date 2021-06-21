<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use Illuminate\Http\JsonResponse;

class MainController extends ApiController
{
    public function health(): JsonResponse
    {
        $response = new ApiModel();
        $response->setData(now());
        $response->setTimestamp(now()->timestamp);
        $response->setCode(ApiCodeEnum::Ok);
        return response()->json($response);
    }
}
