<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByPlace(int $place_id): Collection;
}
