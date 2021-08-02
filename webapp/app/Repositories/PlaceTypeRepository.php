<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlaceTypeRepository extends BaseRepository implements PlaceTypeRepositoryInterface
{
    public function __construct(PlaceType $model)
    {
        parent::__construct($model);
    }

    public function shown(int $place_id): Collection
    {
        return DB::table('place_types')
            ->join('place_to_place_types', 'place_types.id', '=', 'place_to_place_types.place_type_id')
            ->where('place_types.published', '=', 1)
            ->where('place_types.deleted', '=', 0)
            ->where('place_to_place_types.place_id', $place_id)
            ->select('place_types.id', 'place_types.name')
            ->get();
    }
}
