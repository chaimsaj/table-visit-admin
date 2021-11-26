<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use DateTime;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    public function userActiveBookings(int $user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', '=', $user_id)
            //->whereDate('book_date', '>=', today())
            ->where('closed_at', '=', null)
            ->where('canceled_at', '=', null)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function userPastBookings(int $user_id, int $length = 10): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', '=', $user_id)
            ->where('closed_at', '!=', null)
            ->orWhere('canceled_at', '!=', null)
            ->orderBy('id', 'desc')
            ->take($length)
            ->get();
    }

    public function activesPaged(int $start, int $length, string $order_by, string $order, string $search): array
    {
        $query = $this->model->where('deleted', 0)
            ->where('code', 'like', $search . '%')
            ->orWhere('confirmation_code', 'like', $search . '%')
            ->skip($start)
            ->take($length);

        if (!empty($order_by))
            $query = $query->orderBy($order_by, $order);

        $query = $query->get();

        $count = $this->model->count();

        return [
            "data" => $query,
            "count" => $count
        ];
    }

    public function activesPagedByTenant(int $tenant_id, int $start, int $length, string $order_by, string $order, string $search): array
    {
        $query = $this->model->where('deleted', 0)
            ->where('code', 'like', $search . '%')
            ->orWhere('confirmation_code', 'like', $search . '%')
            ->where(function ($query) use ($tenant_id) {
                $query->where("tenant_id", "=", $tenant_id)
                    ->orWhere('tenant_id', "=", null)
                    ->orWhere('tenant_id', "=", 0);
            })
            ->skip($start)
            ->take($length);

        if (!empty($order_by))
            $query = $query->orderBy($order_by, $order);

        $query = $query->get();

        $count = $this->model->count();

        return [
            "data" => $query,
            "count" => $count
        ];
    }

    public function inboxStaff(int $place_id, int $user_type_id, string $search = null): Collection
    {
        // ->whereDate('book_date', '>=', today())

        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('closed_at', '=', null)
            ->where('place_id', $place_id)
            ->where(function ($query) use ($search) {
                if (!empty($search) && strlen($search) >= 2) {
                    $query->where('code', 'like', '%' . $search . '%')
                        ->orWhere('confirmation_code', 'like', '%' . $search . '%');
                }
            })
            ->whereNotExists(
                function ($query) use ($user_type_id) {
                    $query->select(DB::raw(1))
                        ->from('booking_assignments')
                        ->where('user_type_id', $user_type_id)
                        ->whereRaw('booking_assignments.booking_id = bookings.id');
                })
            ->orderBy('id', 'desc')
            ->get();
    }

    public function assignedStaff(int $user_id, string $search = null): Collection
    {
        return DB::table('bookings')
            ->join('booking_assignments', 'bookings.id', '=', 'booking_assignments.booking_id')
            ->where('bookings.deleted', '=', 0)
            ->where('bookings.published', '=', 1)
            ->where('bookings.closed_at', '=', null)
            ->where(function ($query) use ($search) {
                if (!empty($search) && strlen($search) >= 2) {
                    $query->where('bookings.code', 'like', '%' . $search . '%')
                        ->orWhere('bookings.confirmation_code', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('bookings.id', 'desc')
            ->select('bookings.*')
            ->get();
    }

    public function tableSpendsReport(DateTime $date_from, DateTime $date_to, int $place_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->whereDate('book_date', '>=', $date_from)
            ->whereDate('book_date', '<=', $date_to)
            ->where('place_id', '=', $place_id)
            /*->where(function ($query) {
                $query->where('closed_at', '!=', null)
                    ->orWhere('canceled_at', '!=', null);
            })*/
            ->orderBy('id', 'desc')
            ->get();
    }
}
