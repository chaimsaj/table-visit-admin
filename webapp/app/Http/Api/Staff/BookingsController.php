<?php

namespace App\Http\Api\Staff;

use App\AppModels\ApiModel;
use App\Core\MediaSizeEnum;
use App\Core\TableStatusEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
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

    public function __construct(BookingRepositoryInterface $bookingRepository,
                                TableRepositoryInterface   $tableRepository,
                                UserRepositoryInterface    $userRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->tableRepository = $tableRepository;
        $this->userRepository = $userRepository;
    }

    public function inbox(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user) && isset($user->place_id)) {
                    $query = $this->bookingRepository->inboxStaff($user->place_id, $request->get('search'));

                    foreach ($query as $item) {
                        $table = $this->tableRepository->find($item->table_id);
                        $customer = $this->userRepository->find($item->user_id);

                        if (isset($table) && isset($customer)) {
                            $item->table = $table;
                            $item->customer_name = $customer->name;
                            $item->customer_last_name = $customer->last_name;
                            $item->customer_avatar = MediaHelper::getImageUrl(MediaHelper::getUsersPath(), $customer->avatar, MediaSizeEnum::medium);
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

                    if (isset($booking) && !isset($booking->assigned_at)) {
                        $booking->assigned_at = now();

                        if ($request->has('user_id'))
                            $booking->assigned_to_user_id = $request->get('user_id');
                        else
                            $booking->assigned_to_user_id = $user->id;

                        $this->bookingRepository->save($booking);
                    } else {
                        $response->setError("Table already assigned to another user");
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

                        // Open Table
                        $table = $this->tableRepository->find($booking->table_id);

                        if (isset($table)) {
                            $table->table_status = TableStatusEnum::Available;
                            $this->tableRepository->save($table);
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
                    }
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
