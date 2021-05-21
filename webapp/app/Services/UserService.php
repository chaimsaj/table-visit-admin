<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function find($id): ?User
    {

        return $this->userRepository->find($id);
    }

    public function all(): Collection
    {
        return $this->userRepository->all();
    }
}
