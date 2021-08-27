<?php


namespace App\Repositories;

use App\Models\Favorite;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }

    public function exists($place_id, $user_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->where('user_id', $user_id)
            ->first();
    }

    public function userFavorites($user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', $user_id)
            ->get();
    }
}
