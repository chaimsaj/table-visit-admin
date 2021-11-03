<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserSettingRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $user_id, int $setting_type): ?Model;
}
