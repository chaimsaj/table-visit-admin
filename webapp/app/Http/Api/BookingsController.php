<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\BookingStatusEnum;
use App\Helpers\AppHelper;
use App\Helpers\PlaceHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
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
    private TableRepositoryInterface $tableRepository;
    private PlaceTypeRepositoryInterface $placeTypeRepository;

    public function __construct(BookingRepositoryInterface   $bookingRepository,
                                PlaceRepositoryInterface     $placeRepository,
                                TableRepositoryInterface     $tableRepository,
                                PlaceTypeRepositoryInterface $placeTypeRepository,
                                LogServiceInterface          $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->placeRepository = $placeRepository;
        $this->tableRepository = $tableRepository;
        $this->placeTypeRepository = $placeTypeRepository;
    }

    public function book(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            $data = $request->json()->all();

            $validator = Validator::make($data, [
                'rate' => ['required', 'numeric'],
                'tax' => ['required', 'numeric'],
                //'gratuity' => ['required', 'numeric'],
                'total_rate' => ['required', 'numeric'],
                'date' => ['required', 'date'],
                'place_id' => ['required', 'int'],
                'table_id' => ['required', 'int'],
                'table_rate_id' => ['required', 'int'],
            ]);

            if ($validator->fails()) {
                $response->setError($validator->getMessageBag());
                return response()->json($response);
            }

            if (Auth::check()) {
                $user = Auth::user();

                $place = $this->placeRepository->find($request->get('place_id'));
                $table = $this->tableRepository->find($request->get('table_id'));

                if (isset($user) && isset($place) && isset($table)) {
                    $db = new Booking();

                    $db->code = '';
                    $db->confirmation_code = '';
                    $db->amount = $request->get('rate');
                    $db->tax_amount = $request->get('tax');
                    $db->total_amount = $request->get('total_rate');
                    $db->gratuity_amount = $request->get('gratuity');
                    $db->spent_amount = 0;
                    $db->spent_tax = 0;
                    $db->spent_gratuity = 0;
                    $db->spent_total_amount = 0;
                    $db->paid_amount = 0;
                    $db->guests_count = $table->guests_count;
                    $db->book_date = DateTime::createFromFormat('Y-m-d H:i:s', $request->get('date'));
                    $db->booking_status = BookingStatusEnum::Approved;
                    $db->canceled_at = null;
                    $db->approved_at = now();
                    $db->user_id = $user->id;
                    $db->table_id = $request->get('table_id');
                    $db->table_rate_id = $request->get('table_rate_id');
                    $db->place_id = $place->id;
                    $db->tenant_id = $place->tenant_id;
                    $db->published = 1;
                    $db->deleted = 0;

                    if ($request->has('special_comment')) {
                        $db->special_comment = AppHelper::limitString($request->get('special_comment'), 500);
                    }

                    $this->bookingRepository->save($db);

                    // Update Booking Code
                    $db->code = AppHelper::getBookingCode($db->id, $db->place_id);
                    $db->confirmation_code = AppHelper::getBookingConfirmationCode($db->id);

                    $this->bookingRepository->save($db);

                    $response->setData($db);
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
                    $actives = $this->bookingRepository->userActiveBookings($user->id);
                    $pasts = $this->bookingRepository->userPastBookings($user->id);

                    $query = $actives->merge($pasts);

                    foreach ($query as $item) {
                        $item->is_past = ($item->closed_at != null || $item->canceled_at != null);
                        $place = $this->placeRepository->find($item->place_id);

                        if (isset($place)) {
                            $place_types = $this->placeTypeRepository->shown($place->id);
                            $item->place = PlaceHelper::load($place, $place_types);
                        }

                        $amount_to_pay_default = 0.00;

                        $amount_to_pay = round(floatval($item->spent_total_amount) - floatval($item->total_amount), 2);

                        $item->amount_to_pay = strval($amount_to_pay > 0.00 && $item->spent_total_amount != $item->paid_amount ? $amount_to_pay : $amount_to_pay_default);

                        $item->paid = ($item->amount_to_pay == 0.00 || $item->spent_total_amount == $item->paid_amount);
                    }

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
