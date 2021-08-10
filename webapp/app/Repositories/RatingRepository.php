<?php


namespace App\Repositories;

use App\Models\Rating;
use App\Repositories\Base\BaseRepository;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    public function __construct(Rating $model)
    {
        parent::__construct($model);
    }
}
