<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceFeature;
use App\Models\PlaceMusic;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlaceMusicRepository extends BaseRepository implements PlaceMusicRepositoryInterface
{
    public function __construct(PlaceMusic $model)
    {
        parent::__construct($model);
    }

    public function shown(int $place_id): Collection
    {
        return DB::table('place_music')
            ->join('place_to_music', 'place_music.id', '=', 'place_to_music.place_music_id')
            ->where('place_music.published', '=', 1)
            ->where('place_music.deleted', '=', 0)
            ->where('place_to_music.place_id', $place_id)
            ->select('place_music.id', 'place_music.name', 'place_to_music.id AS rel_id')
            ->get();
    }

    public function publishedExclude(Collection $exclude, int $tenant_id = null): Collection
    {
        return $this->model->whereNotIn('id', $exclude)
            ->where('published', '=', 1)
            ->where('deleted', '=', 0)
            ->where(function ($query) use ($tenant_id) {
                if (isset($tenant_id))
                    $query->where("tenant_id", "=", $tenant_id)
                        ->orWhere('tenant_id', "=", null)
                        ->orWhere('tenant_id', "=", 0);
            })
            ->get();
    }
}
