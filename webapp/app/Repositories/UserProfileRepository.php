<?php


namespace App\Repositories;

use App\Models\UserProfile;
use App\Repositories\Base\BaseRepository;

class UserProfileRepository extends BaseRepository implements UserProfileRepositoryInterface
{
    public function __construct(UserProfile $model)
    {
        parent::__construct($model);
    }
}
