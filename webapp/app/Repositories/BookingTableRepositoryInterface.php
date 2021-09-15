<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Stripe\Collection;

interface BookingTableRepositoryInterface extends BaseRepositoryInterface
{
    public function loadFirstByBooking(int $booking_id): ?Model;

    public function loadByBooking(int $booking_id): Collection;
}
