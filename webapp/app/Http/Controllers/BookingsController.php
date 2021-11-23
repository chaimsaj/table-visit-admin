<?php

namespace App\Http\Controllers;

use App\Core\BookingStatusEnum;
use App\Http\Controllers\Base\AdminController;
use App\Repositories\BookingAssignmentRepositoryInterface;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableSpendRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingsController extends AdminController
{
    private BookingRepositoryInterface $bookingRepository;
    private UserRepositoryInterface $userRepository;
    private PlaceRepositoryInterface $placeRepository;
    private TableRepositoryInterface $tableRepository;
    private TableSpendRepositoryInterface $tableSpendRepository;
    private ServiceRepositoryInterface $serviceRepository;
    private BookingAssignmentRepositoryInterface $bookingAssignmentRepository;

    public function __construct(BookingRepositoryInterface           $bookingRepository,
                                UserRepositoryInterface              $userRepository,
                                PlaceRepositoryInterface             $placeRepository,
                                TableRepositoryInterface             $tableRepository,
                                TableSpendRepositoryInterface        $tableSpendRepository,
                                ServiceRepositoryInterface           $serviceRepository,
                                BookingAssignmentRepositoryInterface $bookingAssignmentRepository,
                                LogServiceInterface                  $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
        $this->tableRepository = $tableRepository;
        $this->tableSpendRepository = $tableSpendRepository;
        $this->serviceRepository = $serviceRepository;
        $this->bookingAssignmentRepository = $bookingAssignmentRepository;
    }

    public function index()
    {
        return view('bookings/index');
    }

    public function detail($id)
    {
        $data = $this->bookingRepository->find($id);

        if (isset($data)) {
            $user = $this->userRepository->find($data->user_id);
            $place = $this->placeRepository->find($data->place_id);

            $table_spends = $this->tableSpendRepository->loadByBooking($data->id);
            $service_number = 1;

            $data->table_spends = new Collection();
            $data->table_spends_total = 0;

            foreach ($table_spends as $table_spend) {
                $service = $this->serviceRepository->find($table_spend->service_id);

                if (isset($service)) {
                    $table_spend->service_number = $service_number;
                    $table_spend->service_name = $service->name;

                    $data->table_spends_total += $table_spend->total_amount;

                    $service_number++;
                }
            }

            if (isset($table_spends))
                $data->table_spends = $table_spends;

            if (isset($user))
                $data->customer = $user->name . ' ' . $user->last_name;

            if (isset($place))
                $data->place = $place->name;

            if (!empty($data->book_date)) {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $data->book_date);

                if ($date)
                    $data->book_date = $date->format('m-d-Y');
            }

            if (isset($data->table_id)) {
                $table = $this->tableRepository->find($data->table_id);

                if (isset($table)) {
                    $data->table_name = $table->name;
                    $data->table_number = $table->table_number;
                }
            }

            $bookingAssignments = $this->bookingAssignmentRepository->loadByBooking($data->id);

            $data->staff = new Collection();

            foreach ($bookingAssignments as $bookingAssignment) {
                $staff = $this->userRepository->find($bookingAssignment->user_id);

                if (isset($staff))
                    $data->staff->add($staff);
            }

            $amount_to_pay_default = 0.00;

            $amount_to_pay = round(floatval($data->spent_amount) - floatval($data->total_amount), 2);

            $data->amount_to_pay = strval($amount_to_pay > 0.00 ? $amount_to_pay : $amount_to_pay_default);
        }

        return view('bookings/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }

    public function close($id)
    {
        try {
            $booking = $this->bookingRepository->find($id);

            if (isset($booking) && !isset($booking->closed_by_user_id)) {
                $user = Auth::user();

                $booking->booking_status = BookingStatusEnum::Completed;
                $booking->closed_by_user_id = $user->id;
                $booking->closed_at = now();

                $this->bookingRepository->save($booking);

                $this->closeBookingAssignments($booking->id);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("bookings");
    }

    public function cancel($id)
    {
        try {
            $booking = $this->bookingRepository->find($id);

            if (isset($booking) && !isset($booking->canceled_at)) {

                $booking->booking_status = BookingStatusEnum::Canceled;
                $booking->canceled_at = now();

                $this->bookingRepository->save($booking);

                $this->closeBookingAssignments($booking->id);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("bookings");
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
