<?php


namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function existsByRating($rating_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('rating_id', $rating_id)
            ->first();
    }

    public function userReviews($user_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('user_id', $user_id)
            ->get();
    }
}
