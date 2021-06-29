<?php


namespace App\Services;


use App\Models\PlaceMusic;
use App\Repositories\PlaceMusicRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlaceMusicService implements PlaceMusicServiceInterface
{
    private PlaceMusicRepositoryInterface $repository;

    public function __construct(PlaceMusicRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?PlaceMusic
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
