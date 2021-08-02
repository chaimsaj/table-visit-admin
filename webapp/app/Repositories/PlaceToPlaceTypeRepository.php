<?php


namespace App\Repositories;

use App\Models\PlaceToFeature;
use App\Models\PlaceToPlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceToPlaceTypeRepository extends BaseRepository implements PlaceToPlaceTypeRepositoryInterface
{
    public function __construct(PlaceToPlaceType $model)
    {
        parent::__construct($model);
    }

    public function findByPlace(int $place_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->get();
    }

    public function existsByPlace(int $place_type_id, int $place_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_type_id', $place_type_id)
            ->where('place_id', $place_id)
            ->first();
    }
}
