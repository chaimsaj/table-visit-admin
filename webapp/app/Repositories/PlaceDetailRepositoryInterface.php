<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $place_id, int $language_id): ?Model;
}
