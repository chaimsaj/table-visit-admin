<?php


namespace App\Repositories;

use App\Models\PlaceDetail;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PlaceDetailRepository extends BaseRepository implements PlaceDetailRepositoryInterface
{
    public function __construct(PlaceDetail $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $place_id, int $language_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->where('language_id', $language_id)
            ->first();
    }
}
