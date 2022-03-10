<?php


namespace App\Repositories;

use App\Models\City;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(City $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function publishedByState($state_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('state_id', $state_id)
            ->get();
    }

    public function deleteLogic($id): bool
    {
        try {

            $model = $this->find($id);

            if ($model != null) {
                $model->published = 0;
                $model->show = 0;
                $model->deleted = 1;

                $model->save();
            }

            return true;
        } catch (Throwable $ex) {
            return false;
        }
    }

    public function search(string $word, int $top = 25): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('name', 'like', $word . '%')
            ->orderBy('name', 'asc')
            ->take($top)
            ->get();
    }

    public function top(int $top = 25): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->whereExists(function($query)
            {
                $query->select(DB::raw(1))
                      ->from('places')
                      ->where('deleted', 0)
                      ->where('published',1)
                      ->whereRaw('places.city_id = cities.id');
            })
            ->orderBy('name', 'asc')
            ->take($top)
            ->get();
    }

    public function near(float $lat, float $lon, int $distance) : Collection
    {

        return $this->model->selectRaw("id, name, (6371 * ACOS(SIN(RADIANS(latitude)) * 
        SIN(radians($lat)) + COS(radians(longitude - $lon)) 
        * COS(radians(latitude)) * COS(radians($lat)))) as distance")
        ->havingRaw('distance < ?', [$distance])
        ->orderByRaw('distance ASC')
        ->get();
    }
}
