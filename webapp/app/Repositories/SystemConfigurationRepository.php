<?php


namespace App\Repositories;

use App\Models\SystemConfiguration;
use App\Repositories\Base\BaseRepository;

class SystemConfigurationRepository extends BaseRepository implements SystemConfigurationRepositoryInterface
{
    public function __construct(SystemConfiguration $model)
    {
        parent::__construct($model);
    }
}
