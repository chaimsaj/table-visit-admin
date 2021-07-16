<?php


namespace App\Services;


use App\Models\Booking;
use App\Models\UserToPlace;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\UserToPlaceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserToPlaceService implements UserToPlaceServiceInterface
{
    private UserToPlaceRepositoryInterface $repository;

    public function __construct(UserToPlaceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?UserToPlace
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
        return $this->repository->all();
    }

    public function published(): Collection
    {
        return $this->repository->all();
    }

    public function deleteLogic($id): bool
    {
        return $this->repository->deleteLogic($id);
    }
}
