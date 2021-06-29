<?php


namespace App\Services;


use App\Models\PlaceFeature;
use App\Repositories\PlaceFeatureRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlaceFeatureService implements PlaceFeatureServiceInterface
{
    private PlaceFeatureRepositoryInterface $repository;

    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?PlaceFeature
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
