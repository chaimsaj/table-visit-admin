<?php


namespace App\Services;


use App\Models\Country;
use App\Repositories\CountryRepositoryInterface;

class CountryService implements CountryServiceInterface
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function find($id): ?Country
    {
        return $this->countryRepository->find($id);
    }

    public function delete($id): bool
    {
        return $this->countryRepository->delete($id);
    }
}
