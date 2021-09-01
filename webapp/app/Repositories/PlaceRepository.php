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

    public function byCity(int $city_id, int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('city_id', '=', $city_id)
            ->take($top)
            ->orderBy('name')
            ->get();
    }

    public function featured(int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->take($top)
            ->orderBy('name')
            ->get();
    }

    public function near(int $top = 25): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->take($top)
            ->orderBy('name')
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

    public function favorites($user_id): Collection
    {
        return DB::table('places')
            ->join('favorites', 'places.id', '=', 'favorites.place_id')
            ->where('places.published', '=', 1)
            ->where('places.show', '=', 1)
            ->where('places.deleted', '=', 0)
            ->where('favorites.published', '=', 1)
            ->where('favorites.deleted', '=', 0)
            ->where('favorites.user_id', '=', $user_id)
            ->select('places.*', 'favorites.id AS rel_id')
            ->orderBy('places.name')
            ->get();
    }
}
