<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceToFeatureRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPlace($place_id): Collection;

    public function existsByPlace($feature_id, $place_id): ?Model;
}
