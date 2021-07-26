<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function publishedByCity(int $city_id): Collection;
}
