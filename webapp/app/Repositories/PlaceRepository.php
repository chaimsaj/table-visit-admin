<?php


namespace App\Repositories;

use App\Core\LanguageEnum;
use App\Models\Place;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    public function __construct(Place $model)
    {
        parent::__construct($model);
    }

    public function publishedByCity(int $city_id, int $language_id = LanguageEnum::English): Collection
    {
        return DB::table('places')
            ->leftJoin('place_details', 'places.id', '=', 'place_details.place_id')
            ->where('places.deleted', '=', 0)
            ->where('places.published', '=', 1)
            ->where('places.city_id', '=', $city_id)
            ->where('place_details.deleted', '=', 0)
            ->where('place_details.published', '=', 1)
            ->where('place_details.language_id', '=', $language_id)
            ->select('places.*', 'place_details.detail')
            ->get();
    }
}
