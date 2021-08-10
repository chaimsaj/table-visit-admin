<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\TableDetail;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TableDetailRepository extends BaseRepository implements TableDetailRepositoryInterface
{
    public function __construct(TableDetail $model)
    {
        parent::__construct($model);
    }
}
