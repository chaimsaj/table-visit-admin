<?php


namespace App\Repositories;

use App\Models\BookingGuest;
use App\Repositories\Base\BaseRepository;

class BookingGuestRepository extends BaseRepository implements BookingGuestRepositoryInterface
{
    public function __construct(BookingGuest $model)
    {
        parent::__construct($model);
    }
}
