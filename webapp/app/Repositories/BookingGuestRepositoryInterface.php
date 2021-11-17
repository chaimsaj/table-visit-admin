<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BookingGuestRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByBooking(int $booking_id): Collection;
}
