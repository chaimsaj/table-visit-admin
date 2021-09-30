<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingGuestRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingGuestsController extends ApiController
{
    private BookingGuestRepositoryInterface $bookingGuestRepository;

    public function __construct(BookingGuestRepositoryInterface $bookingGuestRepository,
                                LogServiceInterface             $logger)
    {
        parent::__construct($logger);

        $this->bookingGuestRepository = $bookingGuestRepository;
    }

    public function list(int $booking_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->bookingGuestRepository->published();
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            // $data = $request->json()->all();

            if (Auth::check()) {
                $user = Auth::user();
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
