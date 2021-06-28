<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Base\BaseRepository;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }
}
