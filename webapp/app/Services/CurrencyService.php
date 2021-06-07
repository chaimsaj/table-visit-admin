<?php


namespace App\Services;


use App\Models\Country;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService implements CurrencyServiceInterface
{
    private $repository;

    public function __construct(CurrencyRepositoryInterface $repository)
    {
        $this->$repository = $repository;
    }

    public function find($id): ?Currency
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
