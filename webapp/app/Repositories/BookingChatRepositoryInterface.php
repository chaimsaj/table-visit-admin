<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BookingChatRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $booking_id, int $chat_type): ?Model;

    public function loadByUser(int $from_user_id): Collection;
}
