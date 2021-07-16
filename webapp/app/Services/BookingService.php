<?php


namespace App\Services;


use App\Models\Booking;
use App\Repositories\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BookingService implements BookingServiceInterface
{
    private BookingRepositoryInterface $repository;

    public function __construct(BookingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id): ?Booking
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
