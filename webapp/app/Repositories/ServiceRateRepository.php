<?php


namespace App\Repositories;

use App\Models\ServiceRate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ServiceRateRepository extends BaseRepository implements ServiceRateRepositoryInterface
{
    public function __construct(ServiceRate $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $service_id, int $place_id): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('service_id', '=', $service_id)
            ->where('place_id', '=', $place_id)
            ->get();
    }

    public function firstBy(int $service_id, int $place_id): ?Model
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('service_id', '=', $service_id)
            ->where('place_id', '=', $place_id)
            ->first();
    }
}
