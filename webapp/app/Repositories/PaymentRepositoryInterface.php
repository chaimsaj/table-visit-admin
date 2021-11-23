<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface PaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByBooking(int $booking_id): Collection;
}
