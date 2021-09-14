<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RatingRepositoryInterface extends BaseRepositoryInterface
{
    public function exists($place_id, $user_id): ?Model;

    public function userRatings($user_id): Collection;
}
