<?php


namespace App\Services;


use App\Models\PlaceType;
use App\Repositories\PlaceTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlaceTypeService implements PlaceTypeServiceInterface
{
    private PlaceTypeRepositoryInterface $repository;

    public function __construct(PlaceTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?PlaceType
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
