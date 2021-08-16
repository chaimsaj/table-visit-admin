<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ServiceRateRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $service_id, int $place_id): Collection;

    public function firstBy(int $service_id, int $place_id): ?Model;
}
