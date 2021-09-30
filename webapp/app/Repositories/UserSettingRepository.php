<?php


namespace App\Repositories;

use App\Models\UserSetting;
use App\Repositories\Base\BaseRepository;

class UserSettingRepository extends BaseRepository implements UserSettingRepositoryInterface
{
    public function __construct(UserSetting $model)
    {
        parent::__construct($model);
    }
}
