<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BookingAssignmentRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByBooking(int $booking_id): Collection;

    public function loadForChat(int $booking_id, int $user_type_id): ?Model;

    public function loadBy(int $user_id): Collection;

    public function exists(int $user_id, int $user_type_id, int $booking_id): ?Model;
}
