<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface BookingChatRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $booking_id, int $chat_type): Collection;

    public function loadByUser(int $user_id): Collection;
}
