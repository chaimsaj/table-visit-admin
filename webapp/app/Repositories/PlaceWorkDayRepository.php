<?php


namespace App\Repositories;

use App\Models\PlaceWorkDay;
use App\Repositories\Base\BaseRepository;

class PlaceWorkDayRepository extends BaseRepository implements PlaceWorkDayRepositoryInterface
{
    public function __construct(PlaceWorkDay $model)
    {
        parent::__construct($model);
    }
}
