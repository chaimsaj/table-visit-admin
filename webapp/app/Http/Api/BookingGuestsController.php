<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Models\BookingGuest;
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
                $query = $this->bookingGuestRepository->loadByBooking($booking_id);

                if (isset($query))
                    $response->setData($query);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function save(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $guests = $request->get("guests");

                foreach ($guests as $guest) {
                    try {

                        if ($guest->id != 0)
                            $booking_guest = $this->bookingGuestRepository->find($guest->id);

                        if (!isset($booking_guest))
                            $booking_guest = new BookingGuest();

                        $booking_guest->name = $guest->name;
                        $booking_guest->email = $guest->email;
                        $booking_guest->phone = $guest->phone;
                        $booking_guest->comment = $guest->comment;
                        $booking_guest->booking_id = $guest->booking_id;
                        $booking_guest->place_id = $guest->place_id;
                        $booking_guest->table_id = $guest->table_id;
                        $booking_guest->published = true;
                        $booking_guest->deleted = false;

                        $this->bookingGuestRepository->save($booking_guest);

                    } catch (Throwable $ex) {
                        $this->logger->save($ex);
                    }
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $this->bookingGuestRepository->delete($id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
