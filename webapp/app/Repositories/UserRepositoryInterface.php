<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function actives(): Collection;

    public function activesByPlace(int $place_id): Collection;

    public function published(): Collection;
}
