<?php


namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Base\BaseRepository;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }
}
