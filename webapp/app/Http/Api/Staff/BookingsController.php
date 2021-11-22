<?php

namespace App\Http\Api\Staff;

use App\AppModels\ApiModel;
use App\Core\BookingStatusEnum;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\BookingAssignment;
use App\Repositories\BookingAssignmentRepositoryInterface;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingsController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;
    private TableRepositoryInterface $tableRepository;
    private UserRepositoryInterface $userRepository;
    private BookingAssignmentRepositoryInterface $bookingAssignmentRepository;

    public function __construct(BookingRepositoryInterface           $bookingRepository,
                                TableRepositoryInterface             $tableRepository,
                                UserRepositoryInterface              $userRepository,
                                BookingAssignmentRepositoryInterface $bookingAssignmentRepository,
                                LogServiceInterface                  $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->tableRepository = $tableRepository;
        $this->userRepository = $userRepository;
        $this->bookingAssignmentRepository = $bookingAssignmentRepository;
    }

    public function inbox(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user) && isset($user->place_id)) {
                    $query = $this->bookingRepository->inboxStaff($user->place_id, $user->user_type_id, $request->get('search'));

                    foreach ($query as $item) {
                        $table = $this->tableRepository->find($item->table_id);
                        $customer = $this->userRepository->find($item->user_id);

                        if (isset($table) && isset($customer)) {
                            $item->table = $table;
                            $item->customer_name = $customer->name;
                            $item->customer_last_name = $customer->last_name;
                            $item->customer_avatar = MediaHelper::getImageUrl(MediaHelper::getUsersPath(), $customer->avatar, MediaSizeEnum::medium);
                        }

                        $amount_to_pay = round(floatval($item->spent_amount - $item->total_amount), 2);

                        if ($amount_to_pay > 0)
                            $item->amount_to_pay = $amount_to_pay;
                        else
                            $item->amount_to_pay = floatval(0);
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

    public function assigned(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->bookingRepository->assignedStaff($user->id, $request->get('search'));

                    foreach ($query as $item) {
                        $table = $this->tableRepository->find($item->table_id);
                        $customer = $this->userRepository->find($item->user_id);

                        if (isset($table) && isset($customer)) {
                            $item->table = $table;
                            $item->customer_name = $customer->name;
                            $item->customer_last_name = $customer->last_name;
                            $item->customer_avatar = MediaHelper::getImageUrl(MediaHelper::getUsersPath(), $customer->avatar, MediaSizeEnum::medium);
                        }

                        $amount_to_pay = round(floatval($item->spent_amount - $item->total_amount), 2);

                        if ($amount_to_pay > 0)
                            $item->amount_to_pay = $amount_to_pay;
                        else
                            $item->amount_to_pay = floatval(0);
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

    public function assign(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $booking = $this->bookingRepository->find($request->get('booking_id'));

                    if (isset($booking)) {

                        $exists = $this->bookingAssignmentRepository->exists($user->id, $user->user_type_id, $booking->id);

                        if (!isset($exists)) {
                            $bookingAssignment = new BookingAssignment();
                            $bookingAssignment->date = now();
                            $bookingAssignment->booking_status = BookingStatusEnum::Confirmed;
                            $bookingAssignment->user_id = $user->id;
                            $bookingAssignment->user_type_id = $user->user_type_id;
                            $bookingAssignment->booking_id = $booking->id;
                            $bookingAssignment->table_id = $booking->table_id;
                            $bookingAssignment->published = true;
                            $bookingAssignment->deleted = false;

                            $this->bookingAssignmentRepository->save($bookingAssignment);
                        } else {
                            $response->setError("Table already assigned to another user");
                        }
                    }
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function close(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $booking = $this->bookingRepository->find($request->get('booking_id'));

                    if (isset($booking) && !isset($booking->closed_at)) {
                        $booking->closed_at = now();
                        $booking->closed_by_user_id = $user->id;

                        $this->bookingRepository->save($booking);

                        $this->closeBookingAssignments($booking->id);
                    }
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
                    $booking = $this->bookingRepository->find($request->get('booking_id'));

                    if (isset($booking) && !isset($booking->closed_at)) {
                        $booking->closed_at = now();
                        $booking->canceled_at = now();
                        $booking->closed_by_user_id = $user->id;

                        $this->bookingRepository->save($booking);

                        $this->closeBookingAssignments($booking->id);
                    }
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    private function closeBookingAssignments($booking_id)
    {
        $bookingAssignments = $this->bookingAssignmentRepository->loadByBooking($booking_id);

        foreach ($bookingAssignments as $bookingAssignment) {
            try {
                $bookingAssignment->closed_at = now();
                $this->bookingAssignmentRepository->save($bookingAssignment);
            } catch (Throwable $ex) {
                $this->logger->save($ex);
            }
        }
    }
}
