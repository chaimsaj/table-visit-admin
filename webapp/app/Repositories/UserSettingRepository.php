<?php


namespace App\Repositories;

use App\Core\BookingChatStatusEnum;
use App\Models\UserSetting;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserSettingRepository extends BaseRepository implements UserSettingRepositoryInterface
{
    public function __construct(UserSetting $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $user_id, int $setting_type): ?Model
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('user_id', '=', $user_id)
            ->where('setting_type', '=', $setting_type)
            ->first();
    }
}
