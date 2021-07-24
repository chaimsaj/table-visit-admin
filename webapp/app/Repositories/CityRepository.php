<?php


namespace App\Repositories;

use App\Models\City;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
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

    public function actives_paged(int $start, int $length, string $search): array
    {
        $query = $this->model->where('deleted', 0)
            ->where('name', 'like', $search . '%')
            ->skip($start)
            ->take($length)
            ->get();

        $count = $this->model->count();

        return [
            "data" => $query,
            "count" => $count
        ];
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
}
