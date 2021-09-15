<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\BookingStatusEnum;
use App\Helpers\AppHelper;
use App\Helpers\PlaceHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Booking;
use App\Models\BookingTable;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BookingsController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;
    private PlaceRepositoryInterface $placeRepository;
    private TableRepositoryInterface $tableRepository;
    private BookingServiceRepositoryInterface $bookingServiceRepository;
    private BookingTableRepositoryInterface $bookingTableRepository;

    public function __construct(BookingRepositoryInterface        $bookingRepository,
                                PlaceRepositoryInterface          $placeRepository,
                                TableRepositoryInterface          $tableRepository,
                                BookingServiceRepositoryInterface $bookingServiceRepository,
                                BookingTableRepositoryInterface   $bookingTableRepository,
                                LogServiceInterface               $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->placeRepository = $placeRepository;
        $this->tableRepository = $tableRepository;
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
                'rate' => ['required', 'numeric'],
                'tax' => ['required', 'numeric'],
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
                    $db->guests_count = $table->guests_count;
                    $db->book_date = DateTime::createFromFormat('Y-m-d H:i:s', $request->get('date'));
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

                    // Update Booking Code
                    $db->code = AppHelper::getBookingCode($db->id, $db->place_id);
                    $db->confirmation_code = AppHelper::getBookingConfirmationCode($db->id);
                    $this->bookingRepository->save($db);

                    $booking_table = new BookingTable();
                    $booking_table->rate = $request->get('rate');
                    $booking_table->tax = $request->get('tax');
                    $booking_table->total_rate = $request->get('total_rate');
                    $booking_table->table_number = $table->table_number;
                    $booking_table->table_code = $table->table_number;
                    $booking_table->detail = '';
                    $booking_table->count = 1;

                    if ($request->has('special_comment')) {
                        $booking_table->is_special = 1;
                        $booking_table->special_comment = $request->get('special_comment');
                    } else {
                        $booking_table->is_special = 0;
                        $booking_table->special_comment = '';
                    }

                    $booking_table->canceled_at = null;
                    $booking_table->approved_at = now();
                    $booking_table->table_rate_id = $request->get('table_rate_id');
                    $booking_table->table_id = $request->get('table_id');
                    $booking_table->user_id = $user->id;
                    $booking_table->booking_id = $db->id;
                    $booking_table->published = 1;
                    $booking_table->deleted = 0;

                    $this->bookingTableRepository->save($booking_table);
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

                    foreach ($query as $item) {
                        $db = $this->placeRepository->find($item->place_id);

                        if (isset($db)) {
                            $item->place = PlaceHelper::load($db);
                        }
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
