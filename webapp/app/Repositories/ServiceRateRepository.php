<?php


namespace App\Repositories;

use App\Models\ServiceRate;
use App\Repositories\Base\BaseRepository;

class ServiceRateRepository extends BaseRepository implements ServiceRateRepositoryInterface
{
    public function __construct(ServiceRate $model)
    {
        parent::__construct($model);
    }
}
