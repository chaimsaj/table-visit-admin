<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface TableSpendRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByBooking(int $booking_id): Collection;

    public function loadTotalByBooking(int $booking_id);

    public function loadForCustomer(int $booking_id, int $user_id): Collection;

    public function loadTotalForCustomer(int $booking_id, int $user_id): Collection;
}
