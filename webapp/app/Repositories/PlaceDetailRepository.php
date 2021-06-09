<?php


namespace App\Repositories;

use App\Models\PlaceDetail;
use App\Repositories\Base\BaseRepository;

class PlaceDetailRepository extends BaseRepository implements PlaceDetailRepositoryInterface
{
    public function __construct(PlaceDetail $model)
    {
        parent::__construct($model);
    }
}
