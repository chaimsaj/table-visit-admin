<?php


namespace App\Repositories;

use App\Models\Place;
use App\Repositories\Base\BaseRepository;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    public function __construct(Place $model)
    {
        parent::__construct($model);
    }
}
