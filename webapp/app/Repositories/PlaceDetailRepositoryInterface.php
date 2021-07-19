<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy($place_id, $language_id): ?Model;
}
