<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface FavoriteRepositoryInterface extends BaseRepositoryInterface
{
    public function exists($place_id, $user_id): ?Model;

    public function userFavorites($user_id): Collection;
}
