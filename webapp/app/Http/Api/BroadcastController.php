<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Events\PaymentRequestEvent;
use App\Helpers\GoogleStorageHelper;
use App\Http\Api\Base\ApiController;
use App\Mail\BookingInvitationEmail;
use App\Mail\ForgotPasswordEmail;
use App\Models\Payment;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Throwable;

class BroadcastController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function send(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            if (Auth::check()) {
                //$user = Auth::user();

                PaymentRequestEvent::dispatch("PaymentRequestEvent");
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
