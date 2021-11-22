<?php


namespace App\Repositories;

use App\Models\TableSpend;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TableSpendRepository extends BaseRepository implements TableSpendRepositoryInterface
{
    public function __construct(TableSpend $model)
    {
        parent::__construct($model);
    }

    public function loadByBooking(int $booking_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', $booking_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function loadTotalByBooking(int $booking_id)
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', $booking_id)
            ->sum('total_amount');
    }

    public function loadForCustomer(int $booking_id, int $user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', $booking_id)
            ->where('user_id', $user_id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function loadTotalForCustomer(int $booking_id, int $user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('booking_id', $booking_id)
            ->where('user_id', $user_id)
            ->sum('total_amount');
    }
}
