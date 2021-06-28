<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Models\Language;
use App\Models\Location;
use App\Repositories\Base\BaseRepository;

class LocationRepository extends BaseRepository implements LocationRepositoryInterface
{
    public function __construct(Location $model)
    {
        parent::__construct($model);
    }
}
