<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

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
            ->where('user_id', $user_id)
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
            ->where('user_id', $user_id)
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

    public function inboxStaff(int $place_id, string $search = null): Collection
    {
        // ->whereDate('book_date', '>=', today())

        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('assigned_at', '=', null)
            ->where('closed_at', '=', null)
            ->where('place_id', $place_id)
            ->where(function ($query) use ($search) {
                if (!empty($search) && strlen($search) >= 2) {
                    $query->where('code', 'like', '%' . $search . '%')
                        ->orWhere('confirmation_code', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->get();
    }

    public function assignedStaff(int $user_id, string $search = null): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('assigned_at', '!=', null)
            ->where('assigned_to_user_id', $user_id)
            ->where('closed_at', '=', null)
            ->where(function ($query) use ($search) {
                if (!empty($search) && strlen($search) >= 2) {
                    $query->where('code', 'like', '%' . $search . '%')
                        ->orWhere('confirmation_code', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->get();
    }
}
