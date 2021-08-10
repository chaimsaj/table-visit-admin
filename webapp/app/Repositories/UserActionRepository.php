<?php


namespace App\Repositories;

use App\Models\UserAction;
use App\Repositories\Base\BaseRepository;

class UserActionRepository extends BaseRepository implements UserActionRepositoryInterface
{
    public function __construct(UserAction $model)
    {
        parent::__construct($model);
    }
}
