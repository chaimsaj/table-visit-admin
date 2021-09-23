<?php


namespace App\Repositories;

use App\Models\Commission;
use App\Repositories\Base\BaseRepository;

class CommissionRepository extends BaseRepository implements CommissionRepositoryInterface
{
    public function __construct(Commission $model)
    {
        parent::__construct($model);
    }
}
