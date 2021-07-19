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

    public function restore($id): bool;

    public function save(Model $model): bool;

    public function delete($id): bool;

    public function deleteLogic($id): bool;
}
