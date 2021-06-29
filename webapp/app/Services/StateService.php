<?php


namespace App\Services;


use App\Models\State;
use App\Repositories\StateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StateService implements StateServiceInterface
{
    private StateRepositoryInterface $repository;

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

    public function actives(): Collection
    {
        return $this->repository->actives();
    }

    public function published(): Collection
    {
        return $this->repository->published();
    }

    public function publishedByCountry($country_id): Collection
    {
        return $this->repository->publishedByCountry($country_id);
    }

    public function deleteLogic($id): bool
    {
        return $this->repository->deleteLogic($id);
    }
}
