<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceFeatureRepositoryInterface extends BaseRepositoryInterface
{
    public function shown(int $place_id): Collection;

    public function publishedExclude(Collection $exclude, int $tenant_id): Collection;
}
