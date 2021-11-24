<?php


namespace App\Repositories;

use App\Models\BookingAssignment;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BookingAssignmentRepository extends BaseRepository implements BookingAssignmentRepositoryInterface
{
    public function __construct(BookingAssignment $model)
    {
        parent::__construct($model);
    }

    public function loadByBooking(int $booking_id): Collection
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('booking_id', '=', $booking_id)
            ->get();
    }

    public function loadForChat(int $booking_id, int $user_type_id): ?Model
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('user_type_id', '=', $user_type_id)
            ->where('booking_id', '=', $booking_id)
            ->where('closed_at', '=', null)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function loadBy(int $user_id): Collection
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('user_id', '=', $user_id)
            ->where('closed_at', '=', null)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function exists(int $user_id, int $user_type_id, int $booking_id): ?Model
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('user_id', '=', $user_id)
            ->where('user_type_id', '=', $user_type_id)
            ->where('booking_id', '=', $booking_id)
            ->where('closed_at', '=', null)
            ->orderBy('id', 'desc')
            ->first();
    }
}
