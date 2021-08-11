<?php


namespace App\Repositories;

use App\Core\LanguageEnum;
use App\Models\Place;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
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

    public function featured(int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->take($top)
            ->get();
    }

    public function near(int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->take($top)
            ->get();
    }

    public function search(string $search, int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('name', 'like', '%' . $search . '%')
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->take($top)
            ->get();
    }

    public function activesByTenant(int $tenant_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where("tenant_id", "=", $tenant_id)
            ->orderBy('name', 'asc')
            ->get();
    }
}
