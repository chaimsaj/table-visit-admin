<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Events\MessageSentEvent;
use App\Events\PaymentRequestEvent;
use App\Helpers\BookingHelper;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingAssignmentRepositoryInterface;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Object_;
use Throwable;

class BroadcastController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;
    private PlaceRepositoryInterface $placeRepository;
    private PlaceTypeRepositoryInterface $placeTypeRepository;
    private BookingAssignmentRepositoryInterface $bookingAssignmentRepository;

    public function __construct(BookingRepositoryInterface           $bookingRepository,
                                PlaceRepositoryInterface             $placeRepository,
                                PlaceTypeRepositoryInterface         $placeTypeRepository,
                                BookingAssignmentRepositoryInterface $bookingAssignmentRepository,
                                LogServiceInterface                  $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->placeRepository = $placeRepository;
        $this->placeTypeRepository = $placeTypeRepository;
        $this->bookingAssignmentRepository = $bookingAssignmentRepository;
    }

    public function payment_request(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            if (Auth::check()) {
                $booking = $this->bookingRepository->find($request->get('booking_id'));

                if (isset($booking)) {
                    $place = $this->placeRepository->find($booking->place_id);
                    $place_types = $this->placeTypeRepository->shown($booking->place_id);

                    $data = BookingHelper::load($booking, $place, $place_types);

                    PaymentRequestEvent::dispatch($data->toJson(), $booking->user_id);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function message_sent(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

            if (Auth::check()) {
                $bookingAssignment = $this->bookingAssignmentRepository->loadForChat($request->get('booking_id'),
                    $request->get('type'));

                if (isset($bookingAssignment)) {
                    $data = [
                        'booking_id' => $request->get('booking_id'),
                        'code' => $request->get('code'),
                        'name' => $request->get('name'),
                        'title' => $request->get('title'),
                        'type' => $request->get('type')
                    ];

                    MessageSentEvent::dispatch($data, $bookingAssignment->user_id);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
