<?php


namespace App\Repositories;

use App\Core\BookingChatStatusEnum;
use App\Models\BookingGuest;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BookingGuestRepository extends BaseRepository implements BookingGuestRepositoryInterface
{
    public function __construct(BookingGuest $model)
    {
        parent::__construct($model);
    }

    public function loadByBooking(int $booking_id): Collection
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('booking_id', '=', $booking_id)
            ->orderBy('name')
            ->get();
    }
}
