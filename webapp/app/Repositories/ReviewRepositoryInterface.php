<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ReviewRepositoryInterface extends BaseRepositoryInterface
{
    public function existsByRating($rating_id): ?Model;

    public function userReviews($user_id): Collection;
}
