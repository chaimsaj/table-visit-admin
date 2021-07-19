<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\UserToPlace;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserToPlaceRepository extends BaseRepository implements UserToPlaceRepositoryInterface
{
    public function __construct(UserToPlace $model)
    {
        parent::__construct($model);
    }

    public function findByUser($user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', $user_id)
            ->get();
    }

    public function existsByUser($place_id, $user_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->where('user_id', $user_id)
            ->first();
    }
}
