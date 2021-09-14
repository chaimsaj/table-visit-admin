<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\BookingStatusEnum;
use App\Helpers\AppHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Booking;
use App\Models\Favorite;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\BookingServiceRepositoryInterface;
use App\Repositories\BookingTableRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BookingsController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;
    private PlaceRepositoryInterface $placeRepository;
    private BookingServiceRepositoryInterface $bookingServiceRepository;
    private BookingTableRepositoryInterface $bookingTableRepository;

    public function __construct(BookingRepositoryInterface        $bookingRepository,
                                PlaceRepositoryInterface          $placeRepository,
                                BookingServiceRepositoryInterface $bookingServiceRepository,
                                BookingTableRepositoryInterface   $bookingTableRepository,
                                LogServiceInterface               $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->placeRepository = $placeRepository;
        $this->bookingServiceRepository = $bookingServiceRepository;
        $this->bookingTableRepository = $bookingTableRepository;
    }

    public function book(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'amount' => ['required', 'numeric'],
                'tax_amount' => ['required', 'numeric'],
                'total_amount' => ['required', 'numeric'],
                'date' => ['required', 'date'],
                'place_id' => ['required', 'int'],
                'guests_count' => ['required', 'int']
            ]);

            if ($validator->fails()) {
                $response->setError($validator->getMessageBag());
                return response()->json($response);
            }

            if (Auth::check()) {
                $user = Auth::user();

                $place = $this->placeRepository->find($request->get('place_id'));

                // DateTime::createFromFormat('Y-m-d H:i:s', $request->get('last_update'));

                if (isset($user) && isset($place)) {
                    $db = new Booking();

                    $db->code = 0;
                    $db->confirmation_code = 0;
                    $db->amount = $request->get('amount');
                    $db->tax_amount = $request->get('tax_amount');
                    $db->total_amount = $request->get('total_amount');
                    $db->guests_count = $request->get('guests_count');
                    $db->date = DateTime::createFromFormat('Y-m-d H:i:s', $request->get('date'));

                    if ($request->has('comment'))
                        $db->comment = $request->get('comment');
                    else
                        $db->comment = '';

                    $db->booking_status = BookingStatusEnum::Approved;
                    $db->canceled_at = null;
                    $db->approved_at = now();
                    $db->user_id = $user->id;
                    $db->place_id = $place->id;
                    $db->tenant_id = $place->tenant_id;
                    $db->published = 1;
                    $db->deleted = 0;

                    $this->bookingRepository->save($db);

                    $db->code = AppHelper::getBookingCode($db->id, $db->place_id);
                    $db->confirmation_code = AppHelper::getBookingConfirmationCode($db->id);
                    $this->bookingRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function cancel(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $db = new Booking();

                    $this->bookingRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->bookingRepository->userBookings($user->id);
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
