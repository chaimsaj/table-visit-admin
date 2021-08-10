<?php


namespace App\Repositories;

use App\Models\BookingService;
use App\Repositories\Base\BaseRepository;

class BookingServiceRepository extends BaseRepository implements BookingServiceRepositoryInterface
{
    public function __construct(BookingService $model)
    {
        parent::__construct($model);
    }
}
