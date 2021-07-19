<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserToPlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUser($user_id): Collection;

    public function existsByUser($place_id, $user_id): ?Model;
}
