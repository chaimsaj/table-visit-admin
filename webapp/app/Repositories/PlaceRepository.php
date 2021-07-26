<?php


namespace App\Repositories;

use App\Models\Place;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    public function __construct(Place $model)
    {
        parent::__construct($model);
    }

    public function publishedByCity(int $city_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('city_id', $city_id)
            ->get();
    }
}
