<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function actives(): Collection;

    public function published(): Collection;

    public function publishedByState(int $state_id): Collection;

    public function deleteLogic(int $id): bool;

    public function actives_paged(int $start, int $length, string $search): array;

    public function search(string $word): Collection;
}
