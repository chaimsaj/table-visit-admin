<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\CountryRepositoryInterface;

class UserService implements UserServiceInterface
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function find($id): ?User
    {
        return $this->countryRepository->find($id);
    }
}
