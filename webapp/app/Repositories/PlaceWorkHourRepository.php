<?php


namespace App\Repositories;

use App\Models\PlaceWorkHour;
use App\Repositories\Base\BaseRepository;

class PlaceWorkHourRepository extends BaseRepository implements PlaceWorkHourRepositoryInterface
{
    public function __construct(PlaceWorkHour $model)
    {
        parent::__construct($model);
    }
}
