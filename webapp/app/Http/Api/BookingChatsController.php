<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\BookingChatStatusEnum;
use App\Core\BookingStatusEnum;
use App\Core\TableStatusEnum;
use App\Helpers\AppHelper;
use App\Http\Api\Base\ApiController;
use App\Models\BookingChat;
use App\Repositories\BookingChatRepositoryInterface;
use App\Repositories\BookingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingChatsController extends ApiController
{
    private BookingChatRepositoryInterface $bookingChatRepository;
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingChatRepositoryInterface $bookingChatRepository,
                                BookingRepositoryInterface     $bookingRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->bookingChatRepository = $bookingChatRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function save(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                $booking = $this->bookingRepository->find($request->get('booking_id'));

                if (isset($user) && isset($booking) && !isset($booking->closed_at) && !isset($booking->canceled_at)) {
                    $db = $this->bookingChatRepository->loadBy(intval($request->get('booking_id')), intval($request->get('chat_type')));

                    if (!isset($db))
                        $db = new BookingChat();

                    $db->date = now();
                    $db->chat_text = '';
                    $db->chat_type = intval($request->get('chat_type'));
                    $db->external_name = $request->get('external_name');
                    $db->external_code = $request->get('external_code');
                    $db->chat_status = BookingChatStatusEnum::Opened;
                    $db->booking_id = $booking->id;
                    $db->place_id = $booking->place_id;
                    $db->table_id = $booking->table_id;
                    $db->from_user_id = Auth::user()->id;
                    $db->published = 1;
                    $db->deleted = 0;

                    $this->bookingChatRepository->save($db);
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
                    $query = $this->bookingChatRepository->published();
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
