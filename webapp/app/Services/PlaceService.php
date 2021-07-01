<?php


namespace App\Services;


use App\Models\Place;
use App\Repositories\PlaceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlaceService implements PlaceServiceInterface
{
    private PlaceRepositoryInterface $repository;

    public function __construct(PlaceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?Place
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
