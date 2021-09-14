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

    public function userBookings($user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', $user_id)
            ->get();
    }
}
