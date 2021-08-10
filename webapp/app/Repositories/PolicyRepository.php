<?php


namespace App\Repositories;

use App\Models\Policy;
use App\Repositories\Base\BaseRepository;

class PolicyRepository extends BaseRepository implements PolicyRepositoryInterface
{
    public function __construct(Policy $model)
    {
        parent::__construct($model);
    }
}
