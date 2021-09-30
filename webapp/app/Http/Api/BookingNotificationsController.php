<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingNotificationRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingNotificationsController extends ApiController
{
    private BookingNotificationRepositoryInterface $bookingNotificationRepository;

    public function __construct(BookingNotificationRepositoryInterface $bookingNotificationRepository,
                                LogServiceInterface                    $logger)
    {
        parent::__construct($logger);

        $this->bookingNotificationRepository = $bookingNotificationRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->bookingNotificationRepository->published();
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
