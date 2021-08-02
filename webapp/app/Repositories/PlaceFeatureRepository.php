<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceFeature;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlaceFeatureRepository extends BaseRepository implements PlaceFeatureRepositoryInterface
{
    public function __construct(PlaceFeature $model)
    {
        parent::__construct($model);
    }

    public function shown(int $place_id): Collection
    {
        return DB::table('place_features')
            ->join('place_to_features', 'place_features.id', '=', 'place_to_features.place_feature_id')
            ->where('place_features.published', '=', 1)
            ->where('place_features.deleted', '=', 0)
            ->where('place_to_features.place_id', $place_id)
            ->select('place_features.id', 'place_features.name')
            ->get();
    }
}
