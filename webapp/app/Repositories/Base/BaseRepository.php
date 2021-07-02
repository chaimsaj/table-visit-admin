<?php


namespace App\Repositories\Base;

use App\Repositories\LogRepository;
use App\Repositories\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    /*public function logicDelete($id): bool
    {
        return $this->find($id)->delete();
    }*/

    public function restore($id): bool
    {
        return $this->findOnlyTrashedById($id)->restore();
    }

    public function delete($id): bool
    {
        return $this->find($id)->forceDelete();
    }
}
