<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingsController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(TableRepositoryInterface $bookingRepository,
                                LogServiceInterface      $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $user = Auth::user();


        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
