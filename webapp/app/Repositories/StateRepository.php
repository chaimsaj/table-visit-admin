<?php


namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Base\BaseRepository;

class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    public function __construct(State $model)
    {
        parent::__construct($model);
    }
}
