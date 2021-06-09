<?php


namespace App\Services;


use App\Models\State;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StateService implements StateServiceInterface
{
    private $repository;

    public function __construct(StateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?State
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
}
