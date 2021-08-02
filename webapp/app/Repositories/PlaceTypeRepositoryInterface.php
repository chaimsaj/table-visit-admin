<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface PlaceTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function shown(int $place_id): Collection;
}
