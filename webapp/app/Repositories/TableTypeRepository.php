<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\TableDetail;
use App\Models\TableRate;
use App\Models\TableType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TableTypeRepository extends BaseRepository implements TableTypeRepositoryInterface
{
    public function __construct(TableType $model)
    {
        parent::__construct($model);
    }
}
