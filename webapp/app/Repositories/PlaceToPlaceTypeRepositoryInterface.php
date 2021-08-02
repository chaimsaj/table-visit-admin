<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceToPlaceTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPlace(int $place_id): Collection;

    public function existsByPlace(int $place_type_id, int $place_id): ?Model;
}
