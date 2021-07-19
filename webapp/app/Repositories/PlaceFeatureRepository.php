<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceFeature;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Throwable;

class PlaceFeatureRepository extends BaseRepository implements PlaceFeatureRepositoryInterface
{
    public function __construct(PlaceFeature $model)
    {
        parent::__construct($model);
    }
}
