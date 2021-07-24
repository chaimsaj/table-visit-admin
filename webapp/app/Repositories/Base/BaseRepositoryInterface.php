<?php


namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function create(array $attributes): Model;

    public function find($id): ?Model;

    public function all(): Collection;

    public function actives(): Collection;

    public function published(): Collection;

    public function restore(int $id): bool;

    public function save(Model $model): bool;

    public function delete(int $id): bool;

    public function deleteLogic(int $id): bool;
}
