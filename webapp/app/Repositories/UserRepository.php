<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function activesByTenant(int $tenant_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where("tenant_id", "=", $tenant_id)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function deleteLogic($id): bool
    {
        return $this->deleteLogic($id);
    }
}
