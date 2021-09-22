<?php


namespace App\Repositories;

use App\Models\UserProfile;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserProfileRepository extends BaseRepository implements UserProfileRepositoryInterface
{
    public function __construct(UserProfile $model)
    {
        parent::__construct($model);
    }

    public function loadByUser(int $user_id): ?Model
    {
        return $this->model->where('published', '=', 1)
            ->where('deleted', '=', 0)
            ->where('user_id', '=', $user_id)
            ->first();
    }
}
