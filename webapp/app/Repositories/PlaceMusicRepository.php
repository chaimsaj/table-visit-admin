<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceFeature;
use App\Models\PlaceMusic;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Throwable;

class PlaceMusicRepository extends BaseRepository implements PlaceMusicRepositoryInterface
{
    public function __construct(PlaceMusic $model)
    {
        parent::__construct($model);
    }
}
