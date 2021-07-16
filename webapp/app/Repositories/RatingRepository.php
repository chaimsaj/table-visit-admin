<?php


namespace App\Repositories;

use App\Models\Rating;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class RatingRepository extends BaseRepository implements RatingRepositoryInterface
{
    public function __construct(Rating $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {

    }
}
