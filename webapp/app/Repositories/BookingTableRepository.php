<?php


namespace App\Repositories;

use App\Models\BookingTable;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Stripe\Collection;

class BookingTableRepository extends BaseRepository implements BookingTableRepositoryInterface
{
    public function __construct(BookingTable $model)
    {
        parent::__construct($model);
    }

    public function loadFirstByBooking(int $booking_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', '=', $booking_id)
            ->first();
    }

    public function loadByBooking(int $booking_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', '=', $booking_id)
            ->get();
    }
}
