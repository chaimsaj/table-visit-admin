<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Helpers\GoogleStorageHelper;
use App\Http\Api\Base\ApiController;
use App\Mail\BookingInvitationEmail;
use App\Mail\ForgotPasswordEmail;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MainController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function health(): JsonResponse
    {
        // Mail::to('olegp@aolideas.com')->send(new ForgotPasswordEmail());

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
