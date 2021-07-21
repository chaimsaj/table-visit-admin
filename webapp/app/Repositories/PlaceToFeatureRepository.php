<?php


namespace App\Repositories;

use App\Models\PlaceToFeature;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceToFeatureRepository extends BaseRepository implements PlaceToFeatureRepositoryInterface
{
    public function __construct(PlaceToFeature $model)
    {
        parent::__construct($model);
    }

    public function findByPlace($place_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->get();
    }

    public function existsByPlace($feature_id, $place_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('feature_id', $feature_id)
            ->where('place_id', $place_id)
            ->first();
    }
}
