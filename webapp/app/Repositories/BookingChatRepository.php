<?php


namespace App\Repositories;

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
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('booking_id', '=', $booking_id)
            ->where('chat_type', '=', $chat_type)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function loadByUser(int $user_id): Collection
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('user_id', '=', $user_id)
            ->orderBy('id', 'desc')
            ->get();
    }
}
