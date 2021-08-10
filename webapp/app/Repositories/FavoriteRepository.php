<?php


namespace App\Repositories;

use App\Models\Favorite;
use App\Repositories\Base\BaseRepository;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }
}
