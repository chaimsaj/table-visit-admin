<?php


namespace App\Repositories;

use App\Models\Tenant;
use App\Repositories\Base\BaseRepository;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    public function __construct(Tenant $model)
    {
        parent::__construct($model);
    }
}
