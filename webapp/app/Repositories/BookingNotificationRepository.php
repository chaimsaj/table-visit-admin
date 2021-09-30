<?php


namespace App\Repositories;

use App\Models\BookingNotification;
use App\Repositories\Base\BaseRepository;

class BookingNotificationRepository extends BaseRepository implements BookingNotificationRepositoryInterface
{
    public function __construct(BookingNotification $model)
    {
        parent::__construct($model);
    }
}
