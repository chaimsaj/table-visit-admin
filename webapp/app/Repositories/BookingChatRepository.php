<?php


namespace App\Repositories;

use App\Models\BookingChat;
use App\Repositories\Base\BaseRepository;

class BookingChatRepository extends BaseRepository implements BookingChatRepositoryInterface
{
    public function __construct(BookingChat $model)
    {
        parent::__construct($model);
    }
}
