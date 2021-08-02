<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceMusicRepositoryInterface extends BaseRepositoryInterface
{
    public function shown(int $place_id): Collection;
}
