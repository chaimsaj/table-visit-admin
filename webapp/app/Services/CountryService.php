<?php


namespace App\Services;


use App\Models\Country;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CountryService implements CountryServiceInterface
{
    private CountryRepositoryInterface $repository;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?Country
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
}
