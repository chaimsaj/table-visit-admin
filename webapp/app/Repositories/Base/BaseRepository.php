<?php


namespace App\Repositories\Base;

use App\Repositories\LogRepository;
use App\Repositories\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

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

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->get();
    }

    public function restore($id): bool
    {
        return $this->findOnlyTrashedById($id)->restore();
    }

    public function save(Model $model): bool
    {
        return $model->save();
    }

    public function delete($id): bool
    {
        return $this->find($id)->forceDelete();
    }

    public function deleteLogic($id): bool
    {
        try {
            $for_delete = $this->model->find($id);

            if (isset($for_delete)) {
                $for_delete->published = 0;
                $for_delete->show = 0;
                $for_delete->deleted = 1;

                $this->save($for_delete);
                return true;
            }
        } catch (Throwable $ex) {
            return false;
        }
    }

    public function activesPaged(int $start, int $length, string $search): array
    {
        $query = $this->model->where('deleted', 0)
            ->where('name', 'like', $search . '%')
            ->skip($start)
            ->take($length)
            ->get();

        $count = $this->model->count();

        return [
            "data" => $query,
            "count" => $count
        ];
    }
}
