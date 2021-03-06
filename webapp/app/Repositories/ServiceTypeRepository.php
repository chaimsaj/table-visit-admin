<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class ServiceTypeRepository extends BaseRepository implements ServiceTypeRepositoryInterface
{
    public function __construct(ServiceType $model)
    {
        parent::__construct($model);
    }
}
