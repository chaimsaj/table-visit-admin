<?php


namespace App\Repositories;

use App\Models\Fee;
use App\Repositories\Base\BaseRepository;

class FeeRepository extends BaseRepository implements FeeRepositoryInterface
{
    public function __construct(Fee $model)
    {
        parent::__construct($model);
    }
}
