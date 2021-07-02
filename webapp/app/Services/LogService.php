<?php


namespace App\Services;


use App\Models\Log;
use App\Repositories\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class LogService implements LogServiceInterface
{
    private LogRepositoryInterface $repository;

    public function __construct(LogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?Log
    {
        return $this->repository->find($id);
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function actives(): Collection
    {
        return $this->repository->actives();
    }

    public function published(): Collection
    {
        return $this->repository->published();
    }

    public function deleteLogic($id): bool
    {
        return $this->repository->deleteLogic($id);
    }

    public function save(Throwable $ex): void
    {
        $this->repository->save($ex);
    }
}
