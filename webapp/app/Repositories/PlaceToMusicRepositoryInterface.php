<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceToMusicRepositoryInterface extends BaseRepositoryInterface
{
    public function findByPlace($place_id): Collection;

    public function existsByPlace($place_music_id, $place_id): ?Model;
}
