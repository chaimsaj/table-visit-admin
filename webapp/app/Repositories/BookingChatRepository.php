<?php


namespace App\Repositories;

use App\Core\BookingChatStatusEnum;
use App\Models\BookingChat;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BookingChatRepository extends BaseRepository implements BookingChatRepositoryInterface
{
    public function __construct(BookingChat $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $booking_id, int $chat_type): ?Model
    {
        $status = BookingChatStatusEnum::Opened;

        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('booking_id', '=', $booking_id)
            ->where('chat_type', '=', $chat_type)
            ->where('chat_status', '=', $status)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function loadByUser(int $from_user_id): Collection
    {
        $status = BookingChatStatusEnum::Opened;

        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('from_user_id', '=', $from_user_id)
            ->where('chat_status', '=', $status)
            ->orderBy('id', 'desc')
            ->get();
    }
}
